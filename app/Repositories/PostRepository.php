<?php
declare(strict_types=1);

namespace Oftalvista\Repositories;

use Oftalvista\Core\Cache;
use Oftalvista\Core\Database;

final class PostRepository
{
    public function published(): array
    {
        $redis = Cache::redis();
        $cached = $redis?->get('blog:published');
        if (is_string($cached)) return json_decode($cached, true) ?: [];
        $rows = Database::connection()->query("SELECT * FROM posts WHERE status = 'published' AND published_at <= NOW() ORDER BY published_at DESC")->fetchAll();
        $redis?->setex('blog:published', 300, json_encode($rows));
        return $rows;
    }

    public function all(): array
    {
        return Database::connection()->query('SELECT * FROM posts ORDER BY updated_at DESC')->fetchAll();
    }

    public function findPublished(string $slug): ?array
    {
        $redis = Cache::redis();
        $key = 'blog:post:' . $slug;
        $cached = $redis?->get($key);
        if (is_string($cached)) return json_decode($cached, true) ?: null;
        $statement = Database::connection()->prepare("SELECT * FROM posts WHERE slug = :slug AND status = 'published' AND published_at <= NOW() LIMIT 1");
        $statement->execute(['slug' => $slug]);
        $post = $statement->fetch() ?: null;
        if ($post) $redis?->setex($key, 300, json_encode($post));
        return $post;
    }

    public function find(int $id): ?array
    {
        $statement = Database::connection()->prepare('SELECT * FROM posts WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $id]);
        return $statement->fetch() ?: null;
    }

    public function save(array $data, ?int $id = null): int
    {
        $params = [
            'title' => $data['title'], 'slug' => $data['slug'], 'excerpt' => $data['excerpt'],
            'body' => $data['body'], 'category' => $data['category'], 'author' => $data['author'],
            'image_path' => $data['image_path'], 'image_alt' => $data['image_alt'],
            'reading_minutes' => $data['reading_minutes'], 'status' => $data['status'],
            'published_at' => $data['published_at'], 'meta_description' => $data['meta_description'],
        ];
        if ($id) {
            $params['id'] = $id;
            $sql = 'UPDATE posts SET title=:title, slug=:slug, excerpt=:excerpt, body=:body, category=:category, author=:author, image_path=:image_path, image_alt=:image_alt, reading_minutes=:reading_minutes, status=:status, published_at=:published_at, meta_description=:meta_description, updated_at=NOW() WHERE id=:id RETURNING id';
        } else {
            $sql = 'INSERT INTO posts (title, slug, excerpt, body, category, author, image_path, image_alt, reading_minutes, status, published_at, meta_description) VALUES (:title,:slug,:excerpt,:body,:category,:author,:image_path,:image_alt,:reading_minutes,:status,:published_at,:meta_description) RETURNING id';
        }
        $statement = Database::connection()->prepare($sql);
        $statement->execute($params);
        Cache::forgetBlog();
        return (int) $statement->fetchColumn();
    }

    public function delete(int $id): void
    {
        $statement = Database::connection()->prepare('DELETE FROM posts WHERE id = :id');
        $statement->execute(['id' => $id]);
        Cache::forgetBlog();
    }

    public function slugExists(string $slug, ?int $exceptId = null): bool
    {
        $sql = 'SELECT 1 FROM posts WHERE slug = :slug' . ($exceptId ? ' AND id <> :id' : '') . ' LIMIT 1';
        $statement = Database::connection()->prepare($sql);
        $params = ['slug' => $slug];
        if ($exceptId) $params['id'] = $exceptId;
        $statement->execute($params);
        return (bool) $statement->fetchColumn();
    }
}
