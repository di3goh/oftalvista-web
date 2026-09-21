<?php
declare(strict_types=1);

namespace Oftalvista\Support;

use DateTimeImmutable;

final class PostValidator
{
    public static function validate(array $input): array
    {
        $data = [
            'title' => trim((string) ($input['title'] ?? '')),
            'slug' => strtolower(trim((string) ($input['slug'] ?? ''))),
            'excerpt' => trim((string) ($input['excerpt'] ?? '')),
            'body' => HtmlSanitizer::clean((string) ($input['body'] ?? '')),
            'category' => trim((string) ($input['category'] ?? 'Salud Visual')),
            'author' => trim((string) ($input['author'] ?? 'Clínica Oftalvista')),
            'image_alt' => trim((string) ($input['image_alt'] ?? '')),
            'reading_minutes' => max(1, min(60, (int) ($input['reading_minutes'] ?? 4))),
            'status' => in_array($input['status'] ?? '', ['draft', 'published'], true) ? $input['status'] : 'draft',
            'published_at' => trim((string) ($input['published_at'] ?? '')),
            'meta_description' => trim((string) ($input['meta_description'] ?? '')),
        ];
        if ($data['slug'] === '') $data['slug'] = self::slugify($data['title']);
        $errors = [];
        foreach (['title' => 160, 'slug' => 180, 'excerpt' => 300, 'category' => 80, 'author' => 120, 'image_alt' => 180, 'meta_description' => 170] as $field => $max) {
            if (mb_strlen($data[$field]) > $max) $errors[] = "$field supera $max caracteres";
        }
        if ($data['title'] === '' || $data['excerpt'] === '' || trim(strip_tags($data['body'])) === '') $errors[] = 'Título, resumen y contenido son obligatorios.';
        if (!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $data['slug'])) $errors[] = 'El slug solo acepta letras minúsculas, números y guiones.';
        try {
            $date = $data['published_at'] !== '' ? new DateTimeImmutable($data['published_at']) : new DateTimeImmutable();
            $data['published_at'] = $date->format('Y-m-d H:i:sP');
        } catch (\Throwable) {
            $errors[] = 'La fecha de publicación no es válida.';
        }
        return [$data, $errors];
    }

    public static function slugify(string $value): string
    {
        $ascii = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value) ?: $value;
        return trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($ascii)) ?? '', '-');
    }
}
