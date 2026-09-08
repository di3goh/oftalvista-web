<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/bootstrap.php';

use Oftalvista\Core\Auth;
use Oftalvista\Core\Security;

Security::startSession();
if (Auth::user()) { header('Location: /admin/index.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Security::validateCsrf()) {
        $error = 'La sesión del formulario venció. Recarga e intenta nuevamente.';
    } elseif (Auth::attempt(trim((string) ($_POST['email'] ?? '')), (string) ($_POST['password'] ?? ''))) {
        header('Location: /admin/index.php'); exit;
    } else {
        $error = 'Credenciales inválidas o demasiados intentos. Intenta nuevamente más tarde.';
    }
}
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="robots" content="noindex,nofollow"><title>Acceso administrativo | Oftalvista</title><link rel="stylesheet" href="/assets/css/admin.css"></head><body class="login-page"><main class="login-card"><a class="admin-brand" href="/"><img src="/assets/figma-brand-mark-v2.svg" alt=""><span>Oftalvista <small>Administrador</small></span></a><h1>Bienvenido</h1><p>Ingresa tus credenciales para administrar el sitio.</p><?php if ($error): ?><div class="notice notice--error" role="alert"><?= e($error) ?></div><?php endif; ?><form class="admin-form" method="post" autocomplete="on"><input type="hidden" name="_csrf" value="<?= e(Security::csrfToken()) ?>"><div class="field"><label for="email">Correo</label><input id="email" name="email" type="email" maxlength="254" autocomplete="username" required autofocus></div><div class="field"><label for="password">Contraseña</label><input id="password" name="password" type="password" autocomplete="current-password" required></div><button class="button" type="submit">Ingresar</button></form></main></body></html>
