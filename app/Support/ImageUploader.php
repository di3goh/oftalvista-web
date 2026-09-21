<?php
declare(strict_types=1);

namespace Oftalvista\Support;

use RuntimeException;

final class ImageUploader
{
    private const TYPES = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];

    public static function store(array $file): ?string
    {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) return null;
        if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK || ($file['size'] ?? 0) > 5 * 1024 * 1024) throw new RuntimeException('La imagen no es válida o supera 5 MB.');
        $mime = (new \finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
        if (!isset(self::TYPES[$mime]) || @getimagesize($file['tmp_name']) === false) throw new RuntimeException('Use una imagen JPG, PNG o WebP válida.');
        $name = bin2hex(random_bytes(20)) . '.' . self::TYPES[$mime];
        $directory = dirname(__DIR__, 2) . '/public/uploads';
        if (!is_dir($directory)) mkdir($directory, 0750, true);
        if (!move_uploaded_file($file['tmp_name'], "$directory/$name")) throw new RuntimeException('No se pudo guardar la imagen.');
        return 'uploads/' . $name;
    }

    public static function delete(?string $path): void
    {
        if (!$path || !preg_match('~^uploads/[a-f0-9]{40}\.(?:jpg|png|webp)$~', $path)) return;
        $file = dirname(__DIR__, 2) . '/public/' . $path;
        if (is_file($file)) @unlink($file);
    }
}
