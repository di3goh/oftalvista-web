<?php
declare(strict_types=1);

namespace Oftalvista\Http;

use Oftalvista\Http\Controllers\BlogController;
use Oftalvista\Http\Controllers\HomeController;
use Oftalvista\Http\Controllers\PageController;
use Oftalvista\Http\Controllers\SitemapController;
use Oftalvista\Support\View;

final class Router
{
    private const PAGES = [
        'servicios', 'consulta-oftalmologica', 'cirugia-de-cataratas',
        'cirugia-de-parpados', 'cirugia-de-pterigion', 'testimonios',
        'preguntas', 'terminos-y-condiciones', 'politica-de-privacidad',
    ];

    public function dispatch(string $method, string $uri): void
    {
        if (!in_array($method, ['GET', 'HEAD'], true)) {
            http_response_code(405);
            header('Allow: GET');
            View::render('errors/405');
            return;
        }

        $path = rawurldecode(parse_url($uri, PHP_URL_PATH) ?: '/');
        if ($redirect = $this->legacyRedirect($path)) {
            header('Location: ' . $redirect, true, 301);
            return;
        }

        if ($path === '/') { (new HomeController())(); return; }
        if ($path === '/blog') { (new BlogController())->index(); return; }
        if ($path === '/sitemap.xml') { (new SitemapController())(); return; }
        if (preg_match('~^/blog/([a-z0-9]+(?:-[a-z0-9]+)*)$~', $path, $matches)) {
            (new BlogController())->show($matches[1]);
            return;
        }

        $page = ltrim($path, '/');
        if (in_array($page, self::PAGES, true)) {
            (new PageController())->show($page);
            return;
        }

        http_response_code(404);
        View::render('errors/404');
    }

    private function legacyRedirect(string $path): ?string
    {
        if (in_array($path, ['/index.php', '/index.html'], true)) return '/';
        if (in_array($path, ['/blog.php', '/blog.html'], true)) return '/blog';
        if ($path === '/article.php' && isset($_GET['slug'])) return '/blog/' . rawurlencode((string) $_GET['slug']);
        if (preg_match('~^/blog/([a-z0-9-]+)\.html$~', $path, $matches)) return '/blog/' . $matches[1];

        $legacy = [
            '/Servicios.php' => '/servicios', '/Servicios.html' => '/servicios',
            '/consulta-oftalmologica.php' => '/consulta-oftalmologica', '/consulta-oftalmologica.html' => '/consulta-oftalmologica',
            '/cirugia-de-cataratas.php' => '/cirugia-de-cataratas', '/cirugia-de-cataratas.html' => '/cirugia-de-cataratas',
            '/cirugia-de-parpados.php' => '/cirugia-de-parpados', '/cirugia-de-parpados.html' => '/cirugia-de-parpados',
            '/cirugia-de-pterigion.php' => '/cirugia-de-pterigion', '/cirugia-de-pterigion.html' => '/cirugia-de-pterigion',
            '/testimonios.php' => '/testimonios', '/testimonios.html' => '/testimonios',
            '/preguntas.php' => '/preguntas', '/preguntas.html' => '/preguntas',
            '/terminos-y-condiciones.php' => '/terminos-y-condiciones', '/terminos-y-condiciones.html' => '/terminos-y-condiciones',
            '/politica-de-privacidad.php' => '/politica-de-privacidad', '/politica-de-privacidad.html' => '/politica-de-privacidad',
        ];
        return $legacy[$path] ?? null;
    }
}
