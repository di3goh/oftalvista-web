<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/bootstrap.php';
use Oftalvista\Core\Auth; use Oftalvista\Core\Security; use Oftalvista\Repositories\PostRepository; use Oftalvista\Support\AdminView;
Auth::requireAdmin(); $posts = (new PostRepository())->all(); AdminView::header('Publicaciones', 'posts'); AdminView::flash();
?>
<div class="admin-title"><p>Administra el contenido que aparece en el blog y en la portada.</p><a class="button" href="/admin/post-edit.php">Nueva publicación</a></div>
<div class="table-wrap"><table><thead><tr><th>Título</th><th>Estado</th><th>Publicación</th><th>Actualizado</th><th>Acciones</th></tr></thead><tbody><?php foreach ($posts as $post): ?><tr><td><strong><?= e($post['title']) ?></strong><br><small>/<?= e($post['slug']) ?></small></td><td><span class="status status--<?= e($post['status']) ?>"><?= $post['status'] === 'published' ? 'Publicada' : 'Borrador' ?></span></td><td><?= e((new DateTimeImmutable($post['published_at']))->format('d/m/Y H:i')) ?></td><td><?= e((new DateTimeImmutable($post['updated_at']))->format('d/m/Y H:i')) ?></td><td><div class="actions"><a class="button button--small button--secondary" href="/admin/post-edit.php?id=<?= (int) $post['id'] ?>">Editar</a><form method="post" action="/admin/post-delete.php"><input type="hidden" name="_csrf" value="<?= e(Security::csrfToken()) ?>"><input type="hidden" name="id" value="<?= (int) $post['id'] ?>"><button class="button button--small button--danger" type="submit">Eliminar</button></form></div></td></tr><?php endforeach; ?><?php if (!$posts): ?><tr><td class="empty" colspan="5">Todavía no hay publicaciones.</td></tr><?php endif; ?></tbody></table></div>
<?php AdminView::footer(); ?>
