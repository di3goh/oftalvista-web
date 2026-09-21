<?php
declare(strict_types=1);

putenv('APP_KEY=test-only-key-with-more-than-thirty-two-characters');
putenv('APP_URL=http://localhost:8080');
require dirname(__DIR__) . '/bootstrap.php';

use Oftalvista\Core\Jwt;
use Oftalvista\Support\HtmlSanitizer;
use Oftalvista\Support\PostValidator;

$tests = [];
$test = static function (string $name, callable $callback) use (&$tests): void {
    try { $callback(); $tests[] = [$name, true, '']; }
    catch (Throwable $error) { $tests[] = [$name, false, $error->getMessage()]; }
};
$assert = static function (bool $condition, string $message = 'Aserción fallida'): void { if (!$condition) throw new RuntimeException($message); };

$test('JWT válido conserva identidad y vencimiento', static function () use ($assert): void {
    $token = Jwt::issue(7, 'admin@example.test', 60);
    $claims = Jwt::verify($token);
    $assert($claims['sub'] === '7' && $claims['email'] === 'admin@example.test');
    $assert(substr_count($token, '.') === 2);
});

$test('JWT manipulado es rechazado', static function () use ($assert): void {
    $token = Jwt::issue(1, 'admin@example.test');
    try { Jwt::verify(substr($token, 0, -1) . ($token[-1] === 'a' ? 'b' : 'a')); }
    catch (RuntimeException) { return; }
    $assert(false, 'Se aceptó un JWT manipulado');
});

$test('Sanitizador elimina XSS y conserva contenido permitido', static function () use ($assert): void {
    $clean = HtmlSanitizer::clean('<p onclick="evil()">Hola <strong>mundo</strong></p><script>alert(1)</script><a href="javascript:evil()">x</a>');
    $assert(!str_contains($clean, 'onclick') && !str_contains($clean, '<script') && !str_contains($clean, 'javascript:'));
    $assert(str_contains($clean, '<strong>mundo</strong>'));
});

$test('Validador normaliza slug y estado', static function () use ($assert): void {
    [$data, $errors] = PostValidator::validate(['title'=>'Cuidado de la Visión','excerpt'=>'Resumen','body'=>'<p>Contenido</p>','status'=>'invalid']);
    $assert(!$errors && $data['slug'] === 'cuidado-de-la-vision' && $data['status'] === 'draft');
});

$failed = 0;
foreach ($tests as [$name, $passed, $message]) { echo ($passed ? 'PASS' : 'FAIL') . "  $name" . ($message ? ": $message" : '') . PHP_EOL; if (!$passed) $failed++; }
echo sprintf("%d pruebas, %d fallidas\n", count($tests), $failed);
exit($failed > 0 ? 1 : 0);
