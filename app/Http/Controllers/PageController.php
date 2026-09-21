<?php
declare(strict_types=1);

namespace Oftalvista\Http\Controllers;

use Oftalvista\Support\View;

final class PageController
{
    private const TEMPLATES = [
        'servicios' => 'pages/services',
        'consulta-oftalmologica' => 'pages/consultation',
        'cirugia-de-cataratas' => 'pages/cataract-surgery',
        'cirugia-de-parpados' => 'pages/eyelid-surgery',
        'cirugia-de-pterigion' => 'pages/pterygium-surgery',
        'testimonios' => 'pages/testimonials',
        'preguntas' => 'pages/questions',
        'terminos-y-condiciones' => 'pages/terms',
        'politica-de-privacidad' => 'pages/privacy',
    ];

    public function show(string $page): void
    {
        $template = self::TEMPLATES[$page] ?? null;
        if (!$template) {
            http_response_code(404);
            View::render('errors/404');
            return;
        }
        View::render($template);
    }
}
