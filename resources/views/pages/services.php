<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Conoce los servicios oftalmológicos de Oftalvista: cirugías, consultas y atención especializada.">
    <title>Servicios oftalmológicos | Oftalvista</title>
    <link rel="icon" type="image/png" href="/assets/favicon.png">
    <link rel="stylesheet" href="/assets/css/site.css">
    <script src="/assets/js/site.js" defer></script>
  </head>
  <body class="services-page">
    <div class="page-loader" data-page-loader aria-label="Cargando Oftalvista">
      <div class="page-loader__mark"><img src="/assets/figma-brand-mark-v2.svg" alt=""></div>
      <p class="page-loader__tagline">Cuidamos tu visión, mejoramos tu vida.</p>
      <span class="page-loader__line" aria-hidden="true"></span>
    </div>

    <header class="site-header site-header--scrolled" aria-label="Navegación principal">
      <a class="brand" href="/" aria-label="Oftalvista inicio">
        <img class="brand__mark" src="/assets/figma-brand-mark-v2.svg" alt="">
        <img class="brand__wordmark" src="/assets/figma-wordmark-v2.png" alt="Oftalvista">
      </a>
      <nav class="main-nav" id="main-navigation" aria-label="Secciones">
        <a class="main-nav__link" href="/">Inicio</a>
        <a class="main-nav__link main-nav__link--active" href="/servicios" aria-current="page">Servicios</a>
        <a class="main-nav__link" href="/testimonios">Testimonios</a>
        <a class="main-nav__link" href="/preguntas">Preguntas</a>
        <a class="main-nav__link" href="/blog">Blog</a>
      </nav>
      <div class="header-actions">
        <a class="icon-button" href="tel:+51000000000" aria-label="Llamar a Oftalvista"><img src="/assets/figma-icon-call-v2.svg" alt=""></a>
        <a class="appointment-button" href="/#contacto"><img src="/assets/figma-icon-calendar-v2.svg" alt=""><span>Reserva tu cita</span></a>
      </div>
      <button class="menu-toggle" type="button" aria-label="Abrir menú" aria-expanded="false" aria-controls="main-navigation">
        <span></span><span></span><span></span>
      </button>
    </header>

    <main>
      <section class="services-page__intro" aria-labelledby="services-page-title">
        <div class="section-title section-title--split">
          <h1 id="services-page-title">Nuestros Servicios</h1>
          <p>Cuidado oftalmológico integral con tecnología de punta y especialistas certificados dedicados a la salud de tu visión.</p>
        </div>
        <div class="services-filters" role="group" aria-label="Categorías de servicios">
          <button class="services-filter services-filter--active" type="button" aria-pressed="true">Todos</button>
          <button class="services-filter" type="button" aria-pressed="false">Cirugía</button>
          <button class="services-filter" type="button" aria-pressed="false">Diagnóstico</button>
          <button class="services-filter" type="button" aria-pressed="false">Consultas</button>
          <button class="services-filter" type="button" aria-pressed="false">Estética</button>
        </div>
      </section>

      <section class="services-page__grid" aria-label="Servicios disponibles">
        <a class="service-card service-card--link" href="/cirugia-de-cataratas" data-service-category="cirugia">
          <div class="service-card__media"><img src="/assets/figma-service-cataratas.png" alt="Cirugía de cataratas"><span class="service-card__arrow"><img src="/assets/figma-icon-arrow-v2.svg" alt=""></span></div>
          <div class="service-card__body"><div class="service-card__labels"><span>PROCEDIMIENTO RÁPIDO</span><span>Ambulatorio</span></div><h2>Cirugía de Cataratas</h2><p>Es un procedimiento seguro y altamente efectivo que consiste en retirar el cristalino natural del ojo, que se ha vuelto opaco con el tiempo.</p></div>
        </a>
        <a class="service-card service-card--link" href="/cirugia-de-pterigion" data-service-category="cirugia">
          <div class="service-card__media"><img src="/assets/figma-service-pterigion.png" alt="Cirugía de pterigión o carnosidad ocular"><span class="service-card__arrow"><img src="/assets/figma-icon-arrow-v2.svg" alt=""></span></div>
          <div class="service-card__body"><div class="service-card__labels"><span>TÉCNICA TISULAR</span><span>Sin dolor</span></div><h2>Cirugía de Pterigión</h2><p>La cirugía consiste en la extirpación cuidadosa de este tejido anómalo, seguida de una técnica de reconstrucción de la superficie ocular.</p></div>
        </a>
        <a class="service-card service-card--link" href="/cirugia-de-parpados" data-service-category="estética">
          <div class="service-card__media"><img src="/assets/figma-service-parpados.png" alt="Cirugía de párpados"><span class="service-card__arrow"><img src="/assets/figma-icon-arrow-v2.svg" alt=""></span></div>
          <div class="service-card__body"><div class="service-card__labels"><span>FUNCIONAL Y ESTÉTICA</span><span>Láser CO2</span></div><h2>Cirugía de Párpados</h2><p>Es un procedimiento que corrige el exceso de piel, grasa o flacidez en los párpados superiores e inferiores, por razones estéticas o funcionales.</p></div>
        </a>
        <a class="service-card service-card--link" href="/consulta-oftalmologica" data-service-category="consultas">
          <div class="service-card__media"><img src="/assets/service-consulta.png" alt="Consulta oftalmológica especializada"><span class="service-card__arrow"><img src="/assets/figma-icon-arrow-v2.svg" alt=""></span></div>
          <div class="service-card__body"><div class="service-card__labels"><span>PROCEDIMIENTO RÁPIDO</span><span>Ambulatorio</span></div><h2>Consulta oftalmológica especializada</h2><p>Diagnóstico y tratamiento personalizado para diversas enfermedades oculares, asegurando una atención integral y preventiva.</p></div>
        </a>
      </section>

      <section class="personalized-section" aria-labelledby="services-cta-title">
        <div class="personalized-card">
          <img src="/assets/figma-cta-bg.png" alt="" aria-hidden="true">
          <div class="personalized-card__content"><h2 id="services-cta-title">Atención Personalizada para Cada Paciente</h2><p>Desde la consulta hasta la recuperación, escuchamos tus necesidades y diseñamos planes de tratamiento adaptados a tu estilo de vida y salud visual.</p><a class="white-cta-button" href="/#contacto"><span class="white-cta-button__icon"><img src="/assets/figma-icon-call-white.svg" alt=""></span><span>Agendar una cita</span></a></div>
        </div>
      </section>
    </main>

    <footer class="site-footer" id="contacto">
      <div class="site-footer__inner">
        <section class="footer-brand" aria-label="Oftalvista"><a class="footer-logo" href="/" aria-label="Oftalvista inicio"><img class="footer-logo__mark" src="/assets/figma-brand-mark-footer.svg" alt=""><img class="footer-logo__wordmark" src="/assets/figma-wordmark-v2.png" alt="Oftalvista"></a><p>En Oftalvista, nos especializamos en el cuidado integral de la salud visual, ofreciendo atención profesional y tecnología de vanguardia para el diagnóstico y tratamiento de enfermedades oculares.</p><h3>Lunes a Sabado</h3><div class="footer-row"><img src="/assets/figma-icon-time.svg" alt=""><span>de 9:00 a.m a 7:30 p.m</span></div></section>
        <section class="footer-column" aria-labelledby="footer-contact-title"><h3 id="footer-contact-title">Información de contacto</h3><a class="footer-row" href="https://wa.me/51978662299" target="_blank" rel="noopener"><img src="/assets/figma-icon-whatsapp.svg" alt=""><span>+51 978662299</span></a><a class="footer-row footer-row--address" href="https://maps.google.com/?q=Av.%20Juan%20Pardo%20de%20Zela%20437%2C%20Lince%2015046"><img src="/assets/figma-icon-location.svg" alt=""><span>Av. Juan Pardo de Zela 437, Lince 15046</span></a></section>
        <nav class="footer-column footer-nav" aria-label="Navegación del pie de página"><h3>Navegación</h3><a href="/">Inicio</a><a href="/servicios">Servicios</a><a href="/testimonios">Testimonios</a><a href="/preguntas">Preguntas</a><a href="/blog">Blog</a></nav>
        <section class="footer-column footer-social" aria-labelledby="footer-social-title"><h3 id="footer-social-title">Síguenos en</h3><a class="footer-row" href="#"><img src="/assets/figma-icon-tiktok.svg" alt=""><span>Tiktok</span></a><a class="footer-row" href="#"><img src="/assets/figma-icon-instagram.svg" alt=""><span>Instagram</span></a><a class="footer-row" href="#"><img src="/assets/figma-icon-facebook.svg" alt=""><span>Facebook</span></a></section>
        <nav class="footer-column footer-legal" aria-label="Legal"><h3>Legal</h3><a href="/terminos-y-condiciones">Términos y condiciones</a><a href="/politica-de-privacidad">Política de Privacidad</a></nav>
      </div>
    </footer>
    <div class="subfooter"><p>Diseñado y desarrollado por <a href="#">Diego Mendez</a></p></div>
    <a class="whatsapp-float" href="https://wa.me/51978662299" target="_blank" rel="noopener" aria-label="Escríbenos por WhatsApp"><img src="/assets/figma-icon-whatsapp.svg" alt=""></a>
  </body>
</html>
