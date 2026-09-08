<?php
declare(strict_types=1);

namespace Oftalvista\Support;

final class View
{
    public static function render(string $template, array $data = []): void
    {
        if (!preg_match('/^[a-z0-9-]+(?:\/[a-z0-9-]+)*$/', $template)) {
            throw new \InvalidArgumentException('Nombre de plantilla inválido');
        }
        $path = dirname(__DIR__, 2) . '/resources/views/' . $template . '.php';
        if (!is_file($path)) throw new \RuntimeException('Plantilla no encontrada');
        extract($data, EXTR_SKIP);
        require $path;
    }

    public static function header(string $active = ''): void
    {
        $links = [
            'home' => ['/', cms('nav.home', 'Inicio')],
            'services' => ['/servicios', cms('nav.services', 'Servicios')],
            'testimonials' => ['/testimonios', cms('nav.testimonials', 'Testimonios')],
            'questions' => ['/preguntas', cms('nav.questions', 'Preguntas')],
            'blog' => ['/blog', cms('nav.blog', 'Blog')],
        ];
        ?>
        <header class="site-header site-header--scrolled" aria-label="Navegación principal">
          <a class="brand" href="/" aria-label="Oftalvista inicio"><img class="brand__mark" src="/assets/figma-brand-mark-v2.svg" alt=""><img class="brand__wordmark" src="/assets/figma-wordmark-v2.png" alt="Oftalvista"></a>
          <nav class="main-nav" id="main-navigation" aria-label="Secciones">
            <?php foreach ($links as $key => [$href, $label]): ?><a class="main-nav__link<?= $key === $active ? ' main-nav__link--active' : '' ?>" href="<?= e($href) ?>"<?= $key === $active ? ' aria-current="page"' : '' ?>><?= $label ?></a><?php endforeach; ?>
          </nav>
          <div class="header-actions">
            <a class="icon-button" href="tel:<?= cms('contact.phone', '+51978662299') ?>" aria-label="Llamar a Oftalvista"><img src="/assets/figma-icon-call-v2.svg" alt=""></a>
            <a class="appointment-button" href="<?= self::whatsappUrl() ?>" target="_blank" rel="noopener noreferrer"><img src="/assets/figma-icon-calendar-v2.svg" alt=""><span><?= cms('header.appointment', 'Reserva tu cita') ?></span></a>
          </div>
          <button class="menu-toggle" type="button" aria-label="Abrir menú" aria-expanded="false" aria-controls="main-navigation"><span></span><span></span><span></span></button>
        </header>
        <?php
    }

    public static function footer(): void
    {
        ?>
        <footer class="site-footer" id="contacto"><div class="site-footer__inner">
          <section class="footer-brand" aria-label="Oftalvista"><a class="footer-logo" href="/"><img class="footer-logo__mark" src="/assets/figma-brand-mark-footer.svg" alt=""><img class="footer-logo__wordmark" src="/assets/figma-wordmark-v2.png" alt="Oftalvista"></a><p><?= cms('footer.description') ?></p><h3><?= cms('contact.hours_title', 'Lunes a Sábado') ?></h3><div class="footer-row"><img src="/assets/figma-icon-time.svg" alt=""><span><?= cms('contact.hours') ?></span></div></section>
          <section class="footer-column"><h3>Información de contacto</h3><a class="footer-row" href="<?= self::whatsappUrl() ?>" target="_blank" rel="noopener noreferrer"><img src="/assets/figma-icon-whatsapp.svg" alt=""><span><?= cms('contact.whatsapp') ?></span></a><a class="footer-row footer-row--address" href="https://maps.google.com/?q=<?= rawurlencode(raw_cms('contact.address')) ?>" target="_blank" rel="noopener noreferrer"><img src="/assets/figma-icon-location.svg" alt=""><span><?= cms('contact.address') ?></span></a></section>
          <nav class="footer-column footer-nav" aria-label="Navegación"><h3>Navegación</h3><a href="/"><?= cms('nav.home') ?></a><a href="/servicios"><?= cms('nav.services') ?></a><a href="/testimonios"><?= cms('nav.testimonials') ?></a><a href="/preguntas"><?= cms('nav.questions') ?></a><a href="/blog"><?= cms('nav.blog') ?></a></nav>
          <section class="footer-column footer-social"><h3>Síguenos en</h3><a class="footer-row" href="<?= cms('social.tiktok') ?>" target="_blank" rel="noopener noreferrer"><img src="/assets/figma-icon-tiktok.svg" alt=""><span>Tiktok</span></a><a class="footer-row" href="<?= cms('social.instagram') ?>" target="_blank" rel="noopener noreferrer"><img src="/assets/figma-icon-instagram.svg" alt=""><span>Instagram</span></a><a class="footer-row" href="<?= cms('social.facebook') ?>" target="_blank" rel="noopener noreferrer"><img src="/assets/figma-icon-facebook.svg" alt=""><span>Facebook</span></a></section>
          <nav class="footer-column footer-legal"><h3>Legal</h3><a href="/terminos-y-condiciones">Términos y condiciones</a><a href="/politica-de-privacidad">Política de Privacidad</a></nav>
        </div></footer>
        <div class="subfooter"><p>Oftalvista &copy; <?= date('Y') ?></p></div>
        <a class="whatsapp-float" href="<?= self::whatsappUrl() ?>" target="_blank" rel="noopener noreferrer" aria-label="Escríbenos por WhatsApp"><img src="/assets/figma-icon-whatsapp.svg" alt=""></a>
        <?php
    }

    public static function whatsappUrl(): string
    {
        return 'https://wa.me/' . preg_replace('/\D/', '', raw_cms('contact.whatsapp', '+51978662299')) . '?text=' . rawurlencode('Buenos días, quisiera más información para una consulta oftalmológica.');
    }
}
