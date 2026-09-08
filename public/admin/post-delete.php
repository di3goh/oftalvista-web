<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/bootstrap.php';
use Oftalvista\Core\Auth; use Oftalvista\Core\Security; use Oftalvista\Repositories\PostRepository; use Oftalvista\Support\ImageUploader; use Oftalvista\Support\AdminView;
Auth::requireAdmin();
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !Security::validateCsrf()) { http_response_code(405); exit('Solicitud inválida'); }
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if ($id) { $repository = new PostRepository(); $post = $repository->find($id); $repository->delete($id); ImageUploader::delete($post['image_path'] ?? null); AdminView::setFlash('Publicación eliminada.'); }
header('Location: /admin/posts.php');
