<?php
declare(strict_types=1);

namespace Oftalvista\Core;

final class Security
{
    public static function sendHeaders(): void
    {
        header("Content-Security-Policy: default-src 'self'; img-src 'self' data: https:; style-src 'self' 'unsafe-inline'; script-src 'self'; frame-src https://www.google.com https://www.youtube.com https://www.tiktok.com; connect-src 'self'; base-uri 'self'; form-action 'self'; frame-ancestors 'none'; object-src 'none'");
        header('X-Content-Type-Options: nosniff');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
    }

    public static function startSession(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) return;
        session_name('oftalvista_admin');
        session_set_cookie_params([
            'httponly' => true,
            'secure' => Config::isProduction() && str_starts_with(Config::get('APP_URL'), 'https://'),
            'samesite' => 'Strict',
            'path' => '/admin',
        ]);
        session_start();
    }

    public static function csrfToken(): string
    {
        self::startSession();
        return $_SESSION['csrf'] ??= bin2hex(random_bytes(32));
    }

    public static function validateCsrf(): bool
    {
        self::startSession();
        return isset($_POST['_csrf'], $_SESSION['csrf']) && hash_equals($_SESSION['csrf'], (string) $_POST['_csrf']);
    }

    public static function clientIp(): string
    {
        return substr($_SERVER['REMOTE_ADDR'] ?? 'unknown', 0, 64);
    }
}
