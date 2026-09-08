<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/bootstrap.php';

use Oftalvista\Core\Auth;
use Oftalvista\Core\Security;
use Oftalvista\Repositories\PostRepository;
use Oftalvista\Support\ImageUploader;
use Oftalvista\Support\PostValidator;
use Oftalvista\Support\AdminView;

Auth::requireAdmin();
$repository = new PostRepository();
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?: filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT) ?: null;
$post = $id ? $repository->find((int) $id) : null;
if ($id && !$post) { http_response_code(404); exit('Publicación no encontrada'); }
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Security::validateCsrf()) $errors[] = 'La sesión del formulario venció. Recarga e intenta nuevamente.';
    [$data, $validationErrors] = PostValidator::validate($_POST);
    $errors = [...$errors, ...$validationErrors];
    if ($repository->slugExists($data['slug'], $id ? (int) $id : null)) $errors[] = 'El slug ya está siendo utilizado por otra publicación.';
    try {
        $image = ImageUploader::store($_FILES['image'] ?? []);
        $data['image_path'] = $image ?: (string) ($post['image_path'] ?? '');
        if ($data['image_path'] === '') $errors[] = 'Selecciona una imagen para la publicación.';
    } catch (RuntimeException $error) { $errors[] = $error->getMessage(); $data['image_path'] = (string) ($post['image_path'] ?? ''); }
    if (!$errors) {
        $savedId = $repository->save($data, $id ? (int) $id : null);
        if ($image && !empty($post['image_path']) && $post['image_path'] !== $image) ImageUploader::delete($post['image_path']);
        AdminView::setFlash($id ? 'Publicación actualizada.' : 'Publicación creada.');
        header('Location: /admin/posts.php'); exit;
    }
    $post = array_merge($post ?? [], $data);
}
$post ??= ['title'=>'','slug'=>'','excerpt'=>'','body'=>'','category'=>'Salud Visual','author'=>'Clínica Oftalvista','image_path'=>'','image_alt'=>'','reading_minutes'=>4,'status'=>'draft','published_at'=>date('Y-m-d H:i:s'),'meta_description'=>''];
$publishedValue = (new DateTimeImmutable($post['published_at']))->format('Y-m-d\TH:i');
AdminView::header($id ? 'Editar publicación' : 'Nueva publicación', 'posts');
?>
<?php if ($errors): ?><div class="notice notice--error" role="alert"><strong>Revisa los siguientes campos:</strong><ul><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
<form class="admin-form" method="post" enctype="multipart/form-data"><input type="hidden" name="_csrf" value="<?= e(Security::csrfToken()) ?>"><?php if ($id): ?><input type="hidden" name="id" value="<?= (int) $id ?>"><?php endif; ?>
  <section class="panel"><h2>Contenido</h2><div class="form-grid"><div class="field field--full"><label for="title">Título</label><input id="title" name="title" maxlength="160" value="<?= e($post['title']) ?>" required></div><div class="field"><label for="slug">Slug de la URL</label><input id="slug" name="slug" maxlength="180" pattern="[a-z0-9]+(?:-[a-z0-9]+)*" value="<?= e($post['slug']) ?>"><small>Puede dejarse vacío para generarlo desde el título.</small></div><div class="field"><label for="category">Categoría</label><input id="category" name="category" maxlength="80" value="<?= e($post['category']) ?>" required></div><div class="field field--full"><label for="excerpt">Resumen</label><textarea id="excerpt" name="excerpt" maxlength="300" required><?= e($post['excerpt']) ?></textarea></div><div class="field field--full"><label for="body">Contenido HTML seguro</label><textarea class="editor" id="body" name="body" required><?= e($post['body']) ?></textarea><small>Permitidos: párrafos, H2/H3, listas, negrita, cursiva, citas y enlaces. Scripts, iframes y atributos peligrosos se eliminan.</small></div></div></section>
  <section class="panel"><h2>Publicación y SEO</h2><div class="form-grid"><div class="field"><label for="author">Autor</label><input id="author" name="author" maxlength="120" value="<?= e($post['author']) ?>" required></div><div class="field"><label for="reading_minutes">Minutos de lectura</label><input id="reading_minutes" name="reading_minutes" type="number" min="1" max="60" value="<?= (int) $post['reading_minutes'] ?>" required></div><div class="field"><label for="status">Estado</label><select id="status" name="status"><option value="draft"<?= $post['status']==='draft'?' selected':'' ?>>Borrador</option><option value="published"<?= $post['status']==='published'?' selected':'' ?>>Publicada</option></select></div><div class="field"><label for="published_at">Fecha de publicación</label><input id="published_at" name="published_at" type="datetime-local" value="<?= e($publishedValue) ?>" required></div><div class="field field--full"><label for="meta_description">Descripción SEO</label><textarea id="meta_description" name="meta_description" maxlength="170"><?= e($post['meta_description']) ?></textarea></div></div></section>
  <section class="panel"><h2>Imagen</h2><div class="form-grid"><div class="field"><label for="image">Archivo JPG, PNG o WebP (máx. 5 MB)</label><input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp"<?= $post['image_path'] ? '' : ' required' ?>><?php if ($post['image_path']): ?><small>Actual: <?= e($post['image_path']) ?></small><?php endif; ?></div><div class="field"><label for="image_alt">Texto alternativo</label><input id="image_alt" name="image_alt" maxlength="180" value="<?= e($post['image_alt']) ?>" required></div></div></section>
  <div class="form-actions"><button class="button" type="submit">Guardar publicación</button><a class="button button--secondary" href="/admin/posts.php">Cancelar</a></div>
</form><?php AdminView::footer(); ?>
