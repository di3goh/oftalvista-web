<?php
declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use Oftalvista\Core\Config;
use Oftalvista\Core\Database;
use Oftalvista\Support\HtmlSanitizer;

$password = Config::get('ADMIN_PASSWORD');
$email = filter_var(Config::get('ADMIN_EMAIL', 'admin@oftalvista.local'), FILTER_VALIDATE_EMAIL);
if (!$email || strlen($password) < 12) {
    fwrite(STDERR, "ADMIN_EMAIL debe ser válido y ADMIN_PASSWORD debe tener al menos 12 caracteres.\n");
    exit(1);
}

$pdo = Database::connection();
$hash = password_hash($password, PASSWORD_ARGON2ID);
$admin = $pdo->prepare('INSERT INTO admin_users (email, password_hash) VALUES (:email, :hash) ON CONFLICT (email) DO UPDATE SET password_hash = EXCLUDED.password_hash, active = TRUE, updated_at = NOW()');
$admin->execute(['email' => $email, 'hash' => $hash]);

$count = (int) $pdo->query('SELECT COUNT(*) FROM posts')->fetchColumn();
if ($count === 0) {
    $insert = $pdo->prepare('INSERT INTO posts (title, slug, excerpt, body, category, author, image_path, image_alt, reading_minutes, status, published_at, meta_description) VALUES (:title,:slug,:excerpt,:body,:category,:author,:image_path,:image_alt,:reading_minutes,\'published\',:published_at,:meta_description) ON CONFLICT (slug) DO NOTHING');
    $excerpts = [
        'examen-de-la-vista' => 'La frecuencia ideal para revisar tu salud visual según tu edad y factores de riesgo.',
        'senales-visitar-oftalmologo' => 'Reconoce las alertas que tu cuerpo te da cuando algo no está bien con tu visión.',
        'cataratas-sintomas-causas-tratamiento' => 'Todo lo que debes saber sobre una de las condiciones oculares más frecuentes con la edad.',
        'pterigion-causas-tratamiento' => 'Conoce esta condición ocular, sus causas más comunes y cuándo es necesario tratarla quirúrgicamente.',
        'ojo-seco-causas-sintomas' => 'Una condición cada vez más común, especialmente por el uso excesivo de pantallas.',
        'errores-refractivos' => 'Los errores refractivos más comunes explicados de forma sencilla.',
    ];
    foreach (glob(dirname(__DIR__) . '/database/seeds/articles/*.html') ?: [] as $file) {
        $slug = basename($file, '.html');
        $doc = new DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $doc->loadHTML(file_get_contents($file));
        libxml_clear_errors();
        $xpath = new DOMXPath($doc);
        $text = static fn(string $query): string => trim($xpath->query($query)->item(0)?->textContent ?? '');
        $title = $text("//*[contains(concat(' ', normalize-space(@class), ' '), ' article-heading ')]//h1");
        $bodyNode = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' article-body ')]")->item(0);
        $body = '';
        if ($bodyNode) foreach ($bodyNode->childNodes as $child) $body .= $doc->saveHTML($child);
        $imageNode = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' article-hero ')]//img")->item(0);
        $timeNode = $xpath->query('//time')->item(0);
        if ($title === '' || !$bodyNode) continue;
        $insert->execute([
            'title' => $title,
            'slug' => $slug,
            'excerpt' => $excerpts[$slug] ?? mb_substr(strip_tags($body), 0, 260),
            'body' => HtmlSanitizer::clean($body),
            'category' => 'Salud Visual',
            'author' => 'Clínica Oftalvista',
            'image_path' => ltrim(str_replace('../', '', $imageNode?->getAttribute('src') ?? ''), '/'),
            'image_alt' => $imageNode?->getAttribute('alt') ?? '',
            'reading_minutes' => 4,
            'published_at' => ($timeNode?->getAttribute('datetime') ?: date('Y-m-d')) . ' 12:00:00-05',
            'meta_description' => $excerpts[$slug] ?? '',
        ]);
    }
}

fwrite(STDOUT, "Base de datos y administrador preparados.\n");
