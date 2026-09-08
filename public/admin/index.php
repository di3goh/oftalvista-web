<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/bootstrap.php';

use Oftalvista\Core\Auth;
use Oftalvista\Core\Database;
use Oftalvista\Support\AdminView;

Auth::requireAdmin();
$stats = Database::connection()->query("SELECT COUNT(*) AS total, COUNT(*) FILTER (WHERE status='published') AS published, COUNT(*) FILTER (WHERE status='draft') AS drafts FROM posts")->fetch();
AdminView::header('Resumen', 'dashboard'); AdminView::flash();
?>
<div class="cards"><article class="metric"><span>Publicaciones totales</span><strong><?= (int) $stats['total'] ?></strong></article><article class="metric"><span>Publicadas</span><strong><?= (int) $stats['published'] ?></strong></article><article class="metric"><span>Borradores</span><strong><?= (int) $stats['drafts'] ?></strong></article></div>
<section class="panel"><h2>Acciones rápidas</h2><div class="form-actions"><a class="button" href="/admin/post-edit.php">Crear publicación</a><a class="button button--secondary" href="/admin/settings.php">Editar contenido del sitio</a></div></section>
<?php AdminView::footer(); ?>
