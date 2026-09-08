<?php
declare(strict_types=1);

spl_autoload_register(static function (string $class): void {
    $prefix = 'Oftalvista\\';
    if (!str_starts_with($class, $prefix)) return;
    $path = __DIR__ . '/app/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
    if (is_file($path)) require $path;
});

use Oftalvista\Core\Security;

Security::sendHeaders();

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function cms(string $key, string $fallback = ''): string
{
    return e(Oftalvista\Repositories\SettingsRepository::instance()->get($key, $fallback));
}

function raw_cms(string $key, string $fallback = ''): string
{
    return Oftalvista\Repositories\SettingsRepository::instance()->get($key, $fallback);
}

function asset_url(?string $path, string $fallback = ''): string
{
    $value = $path ?: $fallback;
    if (preg_match('~^https?://~i', $value)) return e($value);
    return '/' . e(ltrim($value, '/'));
}
