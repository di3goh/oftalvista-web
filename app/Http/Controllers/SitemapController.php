<?php
declare(strict_types=1);

namespace Oftalvista\Http\Controllers;

use Oftalvista\Core\Config;
use Oftalvista\Repositories\PostRepository;

final class SitemapController
{
    public function __invoke(): void
    {
        header('Content-Type: application/xml; charset=utf-8');
        header('Cache-Control: public, max-age=300');
        $base = rtrim(Config::get('APP_URL', 'https://oftalvista.com.pe'), '/');
        $staticPages = ['/', '/servicios', '/testimonios', '/preguntas', '/blog', '/cirugia-de-cataratas', '/cirugia-de-pterigion', '/cirugia-de-parpados', '/consulta-oftalmologica'];
        $xml = static fn(string $value): string => htmlspecialchars($value, ENT_XML1 | ENT_QUOTES, 'UTF-8');

        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($staticPages as $path) echo '  <url><loc>' . $xml($base . $path) . '</loc></url>' . "\n";
        foreach ((new PostRepository())->published() as $post) {
            echo '  <url><loc>' . $xml($base . '/blog/' . rawurlencode($post['slug'])) . '</loc><lastmod>' . $xml(substr($post['updated_at'], 0, 10)) . '</lastmod></url>' . "\n";
        }
        echo '</urlset>';
    }
}
