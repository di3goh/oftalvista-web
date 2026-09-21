<?php
declare(strict_types=1);

namespace Oftalvista\Http\Controllers;

use Oftalvista\Repositories\PostRepository;
use Oftalvista\Support\View;

final class HomeController
{
    public function __invoke(): void
    {
        View::render('pages/home', [
            'homePosts' => array_slice((new PostRepository())->published(), 0, 4),
        ]);
    }
}
