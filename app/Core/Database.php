<?php
declare(strict_types=1);

namespace Oftalvista\Core;

use PDO;
use RuntimeException;

final class Database
{
    private static ?PDO $connection = null;

    public static function connection(): PDO
    {
        if (self::$connection) return self::$connection;

        $dsn = sprintf('pgsql:host=%s;port=%s;dbname=%s', Config::get('DB_HOST', 'postgres'), Config::get('DB_PORT', '5432'), Config::get('DB_NAME', 'oftalvista'));
        self::$connection = new PDO($dsn, Config::get('DB_USER', 'oftalvista'), Config::get('DB_PASSWORD'), [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
        return self::$connection;
    }

    public static function assertConfigured(): void
    {
        if (Config::get('DB_PASSWORD') === '') throw new RuntimeException('DB_PASSWORD no configurado');
    }
}
