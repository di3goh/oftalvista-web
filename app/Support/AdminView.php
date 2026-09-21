<?php
declare(strict_types=1);

namespace Oftalvista\Support;

use Oftalvista\Core\Security;

final class AdminView
{
    public static function header(string $title, string $active = ''): void
    {
        $csrf = Security::csrfToken();
        ?>
        <!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="robots" content="noindex,nofollow"><title><?= e($title) ?> | Admin Oftalvista</title><link rel="stylesheet" href="/assets/css/admin.css"></head>
        <body class="admin-body"><header class="admin-topbar"><a class="admin-brand" href="/admin/index.php"><img src="/assets/figma-brand-mark-v2.svg" alt=""><span>Oftalvista <small>Administrador</small></span></a><nav><a class="<?= $active === 'dashboard' ? 'active' : '' ?>" href="/admin/index.php">Resumen</a><a class="<?= $active === 'posts' ? 'active' : '' ?>" href="/admin/posts.php">Publicaciones</a><a class="<?= $active === 'settings' ? 'active' : '' ?>" href="/admin/settings.php">Contenido del sitio</a><a href="/" target="_blank" rel="noopener noreferrer">Ver sitio</a><form method="post" action="/admin/logout.php"><input type="hidden" name="_csrf" value="<?= e($csrf) ?>"><button type="submit">Salir</button></form></nav></header><main class="admin-main"><div class="admin-title"><h1><?= e($title) ?></h1></div>
        <?php
    }

    public static function footer(): void
    {
        echo '</main></body></html>';
    }

    public static function flash(): void
    {
        Security::startSession();
        if (!empty($_SESSION['flash'])) {
            echo '<div class="notice notice--success">' . e($_SESSION['flash']) . '</div>';
            unset($_SESSION['flash']);
        }
    }

    public static function setFlash(string $message): void
    {
        Security::startSession();
        $_SESSION['flash'] = $message;
    }
}
