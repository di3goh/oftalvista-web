<?php
declare(strict_types=1);

namespace Oftalvista\Http\Controllers;

use DateTimeImmutable;
use Oftalvista\Repositories\PostRepository;
use Oftalvista\Support\View;

final class BlogController
{
    public function index(): void
    {
        View::render('pages/blog-index', [
            'posts' => (new PostRepository())->published(),
        ]);
    }

    public function show(string $slug): void
    {
        $post = preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $slug)
            ? (new PostRepository())->findPublished($slug)
            : null;

        if (!$post) {
            http_response_code(404);
            View::render('errors/404');
            return;
        }

        View::render('pages/blog-show', [
            'post' => $post,
            'slug' => $slug,
            'date' => new DateTimeImmutable($post['published_at']),
        ]);
    }
}
