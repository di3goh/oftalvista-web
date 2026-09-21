<?php
declare(strict_types=1);

namespace Oftalvista\Core;

use RuntimeException;

final class Jwt
{
    private static function b64(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private static function decodePart(string $data): string
    {
        $decoded = base64_decode(strtr($data, '-_', '+/'), true);
        if ($decoded === false) throw new RuntimeException('JWT inválido');
        return $decoded;
    }

    public static function issue(int $userId, string $email, int $ttl = 28800): string
    {
        $now = time();
        $header = self::b64(json_encode(['alg' => 'HS256', 'typ' => 'JWT'], JSON_THROW_ON_ERROR));
        $payload = self::b64(json_encode([
            'iss' => Config::get('APP_URL', 'http://localhost:8080'),
            'sub' => (string) $userId,
            'email' => $email,
            'iat' => $now,
            'nbf' => $now,
            'exp' => $now + $ttl,
            'jti' => bin2hex(random_bytes(16)),
        ], JSON_THROW_ON_ERROR));
        $signature = self::b64(hash_hmac('sha256', "$header.$payload", self::key(), true));
        return "$header.$payload.$signature";
    }

    public static function verify(string $token): array
    {
        $parts = explode('.', $token);
        if (count($parts) !== 3) throw new RuntimeException('JWT inválido');
        [$header, $payload, $signature] = $parts;
        $expected = self::b64(hash_hmac('sha256', "$header.$payload", self::key(), true));
        if (!hash_equals($expected, $signature)) throw new RuntimeException('Firma inválida');
        $decodedHeader = json_decode(self::decodePart($header), true, 8, JSON_THROW_ON_ERROR);
        if (($decodedHeader['alg'] ?? '') !== 'HS256' || ($decodedHeader['typ'] ?? '') !== 'JWT') throw new RuntimeException('Cabecera JWT inválida');
        $claims = json_decode(self::decodePart($payload), true, 16, JSON_THROW_ON_ERROR);
        $now = time();
        if (($claims['exp'] ?? 0) < $now || ($claims['nbf'] ?? PHP_INT_MAX) > $now) throw new RuntimeException('JWT vencido');
        if (($claims['iss'] ?? '') !== Config::get('APP_URL', 'http://localhost:8080')) throw new RuntimeException('Emisor inválido');
        if (!isset($claims['sub'], $claims['email'], $claims['jti']) || !ctype_digit((string) $claims['sub']) || !filter_var($claims['email'], FILTER_VALIDATE_EMAIL)) throw new RuntimeException('Claims JWT inválidos');
        $redis = Cache::redis();
        if ($redis && $redis->exists('jwt:revoked:' . ($claims['jti'] ?? ''))) throw new RuntimeException('JWT revocado');
        return $claims;
    }

    public static function revoke(string $token): void
    {
        try {
            $claims = self::verify($token);
            $ttl = max(1, (int) $claims['exp'] - time());
            Cache::redis()?->setex('jwt:revoked:' . $claims['jti'], $ttl, '1');
        } catch (RuntimeException) {
        }
    }

    private static function key(): string
    {
        $key = Config::get('APP_KEY');
        if (strlen($key) < 32) throw new RuntimeException('APP_KEY debe tener al menos 32 caracteres');
        return $key;
    }
}
