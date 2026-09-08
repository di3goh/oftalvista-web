<?php
declare(strict_types=1);

namespace Oftalvista\Core;

use Oftalvista\Repositories\UserRepository;
use RuntimeException;

final class Auth
{
    public const COOKIE = 'oftalvista_token';

    public static function attempt(string $email, string $password): bool
    {
        $key = 'login:' . hash('sha256', strtolower($email) . '|' . Security::clientIp());
        $redis = Cache::redis();
        if ($redis && (int) $redis->get($key) >= 5) return false;
        $user = (new UserRepository())->findByEmail($email);
        if (!$user || !password_verify($password, $user['password_hash'])) {
            if ($redis) {
                $count = $redis->incr($key);
                if ($count === 1) $redis->expire($key, 900);
            }
            usleep(250000);
            return false;
        }
        $redis?->del($key);
        if (password_needs_rehash($user['password_hash'], PASSWORD_ARGON2ID)) {
            (new UserRepository())->updatePassword((int) $user['id'], password_hash($password, PASSWORD_ARGON2ID));
        }
        self::setCookie(Jwt::issue((int) $user['id'], $user['email']));
        session_regenerate_id(true);
        return true;
    }

    public static function user(): ?array
    {
        $token = $_COOKIE[self::COOKIE] ?? '';
        if ($token === '') return null;
        try {
            $claims = Jwt::verify($token);
            return ['id' => (int) $claims['sub'], 'email' => $claims['email']];
        } catch (RuntimeException) {
            self::clearCookie();
            return null;
        }
    }

    public static function requireAdmin(): array
    {
        $user = self::user();
        if (!$user) {
            header('Location: /admin/login.php', true, 302);
            exit;
        }
        return $user;
    }

    public static function logout(): void
    {
        $token = $_COOKIE[self::COOKIE] ?? '';
        if ($token !== '') Jwt::revoke($token);
        self::clearCookie();
        Security::startSession();
        $_SESSION = [];
        session_destroy();
    }

    private static function setCookie(string $token): void
    {
        setcookie(self::COOKIE, $token, [
            'expires' => time() + 28800,
            'path' => '/admin',
            'secure' => Config::isProduction() && str_starts_with(Config::get('APP_URL'), 'https://'),
            'httponly' => true,
            'samesite' => 'Strict',
        ]);
        $_COOKIE[self::COOKIE] = $token;
    }

    private static function clearCookie(): void
    {
        setcookie(self::COOKIE, '', ['expires' => 1, 'path' => '/admin', 'httponly' => true, 'samesite' => 'Strict']);
        unset($_COOKIE[self::COOKIE]);
    }
}
