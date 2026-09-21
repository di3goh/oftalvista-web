<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/bootstrap.php';
use Oftalvista\Core\Auth; use Oftalvista\Core\Security; use Oftalvista\Repositories\SettingsRepository; use Oftalvista\Support\AdminView;
Auth::requireAdmin();
$groups = [
 'Navegación y acciones' => ['nav.home'=>'Inicio','nav.services'=>'Servicios','nav.testimonials'=>'Testimonios','nav.questions'=>'Preguntas','nav.blog'=>'Blog','header.appointment'=>'Botón de cita'],
 'Portada principal' => ['site.tagline'=>'Frase del cargador','home.hero_title_before'=>'Título antes de la palabra destacada','home.hero_highlight'=>'Palabra destacada','home.hero_title_after'=>'Título después de la palabra destacada','home.hero_description'=>'Descripción','home.stat_patients_value'=>'Cifra de pacientes','home.stat_patients_label'=>'Etiqueta de pacientes','home.stat_surgeries_value'=>'Cifra de cirugías','home.stat_surgeries_label'=>'Etiqueta de cirugías','home.stat_experience_value'=>'Cifra de experiencia','home.stat_experience_label'=>'Etiqueta de experiencia'],
 'Secciones del inicio' => ['home.services_title'=>'Título de servicios','home.services_description'=>'Descripción de servicios','home.blog_title'=>'Título del blog en inicio','home.blog_description'=>'Descripción del blog en inicio'],
 'Página del blog' => ['blog.title'=>'Título del blog','blog.description'=>'Descripción del blog'],
 'Contacto y pie de página' => ['contact.phone'=>'Teléfono','contact.whatsapp'=>'WhatsApp','contact.address'=>'Dirección','contact.hours_title'=>'Título del horario','contact.hours'=>'Horario','footer.description'=>'Descripción institucional','social.tiktok'=>'URL de TikTok','social.instagram'=>'URL de Instagram','social.facebook'=>'URL de Facebook'],
];
$allowed = array_merge(...array_map('array_keys', array_values($groups)));
$repository = SettingsRepository::instance(); $error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 if (!Security::validateCsrf()) $error = 'La sesión del formulario venció. Recarga e intenta nuevamente.';
 else { $values=[]; foreach ($allowed as $key) $values[$key]=mb_substr(trim((string)($_POST['settings'][$key]??'')),0,1000); $repository->updateMany($values); AdminView::setFlash('Contenido del sitio actualizado.'); header('Location: /admin/settings.php'); exit; }
}
$settings=$repository->all(); AdminView::header('Contenido del sitio','settings'); AdminView::flash();
?>
<p>Edita textos, contacto y enlaces sin modificar la estructura ni el diseño de la página.</p><?php if ($error): ?><div class="notice notice--error"><?= e($error) ?></div><?php endif; ?><form class="admin-form" method="post"><input type="hidden" name="_csrf" value="<?= e(Security::csrfToken()) ?>"><?php foreach($groups as $group=>$fields): ?><section class="panel"><h2><?= e($group) ?></h2><div class="form-grid"><?php foreach($fields as $key=>$label): ?><div class="field<?= str_contains($key,'description') ? ' field--full':'' ?>"><label for="<?= e($key) ?>"><?= e($label) ?></label><?php if(str_contains($key,'description')): ?><textarea id="<?= e($key) ?>" name="settings[<?= e($key) ?>]" maxlength="1000"><?= e($settings[$key]??'') ?></textarea><?php else: ?><input id="<?= e($key) ?>" name="settings[<?= e($key) ?>]" maxlength="1000" value="<?= e($settings[$key]??'') ?>"><?php endif; ?></div><?php endforeach; ?></div></section><?php endforeach; ?><div class="form-actions"><button class="button" type="submit">Guardar cambios</button><a class="button button--secondary" href="/" target="_blank" rel="noopener noreferrer">Previsualizar sitio</a></div></form>
<?php AdminView::footer(); ?>
