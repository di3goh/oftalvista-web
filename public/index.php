<?php
declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

(new Oftalvista\Http\Router())->dispatch(
    $_SERVER['REQUEST_METHOD'] ?? 'GET',
    $_SERVER['REQUEST_URI'] ?? '/',
);
