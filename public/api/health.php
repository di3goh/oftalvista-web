<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/bootstrap.php';

use Oftalvista\Core\Cache;
use Oftalvista\Core\Database;

header('Content-Type: application/json; charset=utf-8');
try {
    Database::connection()->query('SELECT 1');
    $redis = Cache::redis();
    if (!$redis || !$redis->ping()) throw new RuntimeException('Redis no disponible');
    echo json_encode(['status' => 'ok', 'postgres' => 'ok', 'redis' => 'ok'], JSON_THROW_ON_ERROR);
} catch (Throwable $error) {
    http_response_code(503);
    echo json_encode(['status' => 'error'], JSON_THROW_ON_ERROR);
}
