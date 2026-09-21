<?php
declare(strict_types=1);

// Vercel invokes PHP functions from /api. Route the original request into
// the existing public PHP application without changing its URLs.
$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$requestPath = '/' . ltrim($requestPath, '/');

$routes = [
    '/' => '/index.php',
];
$target = $routes[$requestPath] ?? $requestPath;

if (!str_ends_with($target, '.php')) {
    $target = '/index.php';
}

$target = realpath(__DIR__ . '/../public' . $target);
$publicRoot = realpath(__DIR__ . '/../public');

if ($target === false || $publicRoot === false || !str_starts_with($target, $publicRoot . DIRECTORY_SEPARATOR) || !is_file($target)) {
    http_response_code(404);
    echo 'Not Found';
    exit;
}

require $target;
