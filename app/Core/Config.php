<?php
declare(strict_types=1);

namespace Oftalvista\Core;

final class Config
{
    public static function get(string $key, ?string $default = null): string
    {
        $value = getenv($key);
        return $value === false || $value === '' ? ($default ?? '') : $value;
    }

    public static function isProduction(): bool
    {
        return self::get('APP_ENV', 'production') === 'production';
    }
}
