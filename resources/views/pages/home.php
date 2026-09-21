<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Clínica oftalmológica en Lince, Lima. Atención especializada para el cuidado de tu visión, consultas y cirugías oculares.">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://oftalvista.com.pe/">
    <title>Oftalvista | Clínica oftalmológica en Lima</title>
    <link rel="icon" type="image/png" href="/assets/favicon.png">
    <link rel="stylesheet" href="/assets/css/site.css">
    <script src="/assets/js/site.js" defer></script>
    <script type="application/ld+json">
      {
        "@context": "https://schema.org",
        "@type": "MedicalClinic",
        "name": "Oftalvista",
        "url": "https://oftalvista.com.pe/",
        "telephone": "+51978662299",
        "logo": "https://oftalvista.com.pe/assets/favicon.png",
        "address": {
          "@type": "PostalAddress",
          "streetAddress": "Av. Juan Pardo de Zela 437",
          "addressLocality": "Lince",
          "addressRegion": "Lima",
          "postalCode": "15046",
          "addressCountry": "PE"
        },
        "sameAs": [
          "https://www.tiktok.com/@cmoftalvista",
          "https://www.instagram.com/oftalvista.oliveros/",
          "https://www.facebook.com/profile.php?id=100064055949475"
        ]
      }
    </script>
  </head>
  <body class="home-page">
    <div class="page-loader" data-page-loader aria-label="Cargando Oftalvista">
      <div class="page-loader__mark"><img src="/assets/figma-brand-mark-v2.svg" alt=""></div>
      <p class="page-loader__tagline"><?= cms('site.tagline', 'Cuidamos tu visión, mejoramos tu vida.') ?></p>
      <span class="page-loader__line" aria-hidden="true"></span>
    </div>
    <main class="page-shell">
      <section class="hero" id="inicio" aria-label="Principal">
        <div class="hero__background" aria-hidden="true"></div>

        <header class="site-header" aria-label="Navegación principal">
          <a class="brand" href="#inicio" aria-label="Oftalvista inicio">
            <img class="brand__mark" src="/assets/figma-brand-mark-v2.svg" alt="">
            <img class="brand__wordmark" src="/assets/figma-wordmark-v2.png" alt="">
          </a>

          <nav class="main-nav" id="main-navigation" aria-label="Secciones">
            <a class="main-nav__link main-nav__link--active" href="#inicio"><?= cms('nav.home', 'Inicio') ?></a>
            <a class="main-nav__link" href="/servicios"><?= cms('nav.services', 'Servicios') ?></a>
            <a class="main-nav__link" href="/testimonios"><?= cms('nav.testimonials', 'Testimonios') ?></a>
            <a class="main-nav__link" href="/preguntas"><?= cms('nav.questions', 'Preguntas') ?></a>
            <a class="main-nav__link" href="/blog"><?= cms('nav.blog', 'Blog') ?></a>
          </nav>

          <div class="header-actions">
            <a class="icon-button" href="tel:+51000000000" aria-label="Llamar a Oftalvista">
              <img src="/assets/figma-icon-call-v2.svg" alt="">
            </a>
            <a class="appointment-button" href="#contacto">
              <img src="/assets/figma-icon-calendar-v2.svg" alt="">
              <span><?= cms('header.appointment', 'Reserva tu cita') ?></span>
            </a>
          </div>

          <button class="menu-toggle" type="button" aria-label="Abrir menú" aria-expanded="false" aria-controls="main-navigation">
            <span></span>
            <span></span>
            <span></span>
          </button>
        </header>

        <div class="hero__content">
          <div class="hero-copy">
            <h1>
              <?= cms('home.hero_title_before', 'Cuidamos la salud de tu') ?> <span><?= cms('home.hero_highlight', 'visión') ?></span> <?= cms('home.hero_title_after', 'con especialistas en oftalmología') ?>
            </h1>
            <p>
              <?= cms('home.hero_description', 'Diagnóstico, prevención y tratamiento para la salud visual de niños, adultos y adultos mayores.') ?>
            </p>

            <div class="stats" aria-label="Indicadores de confianza">
              <article class="stat">
                <span class="stat__icon"><img src="/assets/figma-icon-happy-v2.svg" alt=""></span>
                <span class="stat__text">
                  <strong><?= cms('home.stat_patients_value', '200+') ?></strong>
                  <small><?= cms('home.stat_patients_label', 'Pacientes Felices') ?></small>
                </span>
              </article>
              <article class="stat">
                <span class="stat__icon"><img src="/assets/figma-icon-eye-v2.svg" alt=""></span>
                <span class="stat__text">
                  <strong><?= cms('home.stat_surgeries_value', '50+') ?></strong>
                  <small><?= cms('home.stat_surgeries_label', 'Cirugías Exitosas') ?></small>
                </span>
              </article>
              <article class="stat">
                <span class="stat__icon"><img src="/assets/figma-icon-star-v2.svg" alt=""></span>
                <span class="stat__text">
                  <strong><?= cms('home.stat_experience_value', '15+') ?></strong>
                  <small><?= cms('home.stat_experience_label', 'Años de experiencia') ?></small>
                </span>
              </article>
            </div>
          </div>

          <aside class="doctor-card" aria-label="Doctor destacado">
            <img class="doctor-card__photo" src="/assets/figma-doctor-v2.png" alt="Dr. Aníbal Olivera">
            <div class="doctor-card__body">
              <h2>DR. Anibal Olivera</h2>
              <p>Médico y cirujano oftalmólogo</p>
              <a href="https://www.tiktok.com/@cmoftalvista/video/7663956063024139527" target="_blank" rel="noopener">Conoce a tu Doctor</a>
            </div>
          </aside>
        </div>
      </section>

      <aside class="address-strip" aria-label="Dirección">
        <?= cms('contact.address', 'Av. Juan Pardo de Zela 437, Lince 15046') ?>
      </aside>

      <section class="section services-section reveal-section" id="servicios" aria-labelledby="services-title">
        <div class="section-title section-title--split">
          <h2 id="services-title"><?= cms('home.services_title', 'Nuestros servicios a tu disposición') ?></h2>
          <p>
            <?= cms('home.services_description', 'Escuchamos, comprendemos y ofrecemos un cuidado oftalmológico de clase mundial que ha devuelto la visión a miles de pacientes.') ?>
          </p>
        </div>

        <div class="services-grid">
          <a class="service-card service-card--link" href="/cirugia-de-cataratas" aria-label="Ver página de cirugía de cataratas">
            <div class="service-card__media">
              <img src="/assets/figma-service-cataratas.png" alt="Consulta para cirugía de cataratas">
              <span class="service-card__arrow"><img src="/assets/figma-icon-arrow-v2.svg" alt=""></span>
            </div>
            <div class="service-card__body">
              <h3>Cirugía de Cataratas</h3>
              <p>Es un procedimiento seguro y altamente efectivo que consiste en retirar el cristalino natural del ojo, que se ha vuelto opaco con el tiempo.</p>
            </div>
          </a>

          <a class="service-card service-card--link" href="/cirugia-de-pterigion" aria-label="Ver página de cirugía de pterigión">
            <div class="service-card__media">
              <img src="/assets/figma-service-pterigion.png" alt="Explicación médica de pterigión o carnosidad ocular">
              <span class="service-card__arrow"><img src="/assets/figma-icon-arrow-v2.svg" alt=""></span>
            </div>
            <div class="service-card__body">
              <h3>Cirugía de Pterigión</h3>
              <p>La cirugía consiste en la extirpación cuidadosa de este tejido anómalo, seguida de una técnica de reconstrucción de la superficie ocular.</p>
            </div>
          </a>

          <a class="service-card service-card--link" href="/cirugia-de-parpados" aria-label="Ver página de cirugía de párpados">
            <div class="service-card__media">
              <img src="/assets/figma-service-parpados.png" alt="Evaluación para cirugía de párpados">
              <span class="service-card__arrow"><img src="/assets/figma-icon-arrow-v2.svg" alt=""></span>
            </div>
            <div class="service-card__body">
              <h3>Cirugía de Párpados</h3>
              <p>Es un procedimiento que corrige el exceso de piel, grasa o flacidez en los párpados superiores e inferiores, ya sea por razones estéticas o funcionales.</p>
            </div>
          </a>
        </div>

        <a class="pill-button" href="#todos-servicios">
          <span>Ver todos los servicios</span>
          <img src="/assets/figma-icon-arrow-v2.svg" alt="">
        </a>
      </section>

      <section class="section results-section reveal-section" id="resultados" aria-labelledby="results-title">
        <div class="section-title">
          <h2 id="results-title">Antes y después</h2>
          <p>Descubre los resultados reales de nuestros tratamientos en la vida de nuestros pacientes.</p>
        </div>

        <div class="comparison-grid">
          <article class="result-card">
            <div class="comparison" data-comparison style="--position: 50%;">
              <img class="comparison__image" src="/assets/case-before-pterigion-web.jpg" alt="Antes de cirugía de pterigión" loading="lazy" decoding="async">
              <div class="comparison__after" aria-hidden="true">
                <img src="/assets/case-after-pterigion-web.jpg" alt="" loading="lazy" decoding="async">
              </div>
              <div class="comparison__divider" aria-hidden="true"></div>
              <div class="comparison__handle" aria-hidden="true">
                <span class="comparison__arrow comparison__arrow--left"></span>
                <span class="comparison__arrow comparison__arrow--right"></span>
              </div>
              <input class="comparison__range" type="range" min="0" max="100" value="50" aria-label="Deslizar antes y después de cirugía de pterigión">
            </div>
            <div class="result-card__body">
              <h3>Cirugía de Pterigión</h3>
              <p>Removimos con éxito un pterigión avanzado, devolviendo al paciente una córnea sana y una visión más clara.</p>
            </div>
          </article>

          <article class="result-card">
            <div class="comparison" data-comparison style="--position: 50%;">
              <img class="comparison__image" src="/assets/case-before-cataratas-web.jpg" alt="Antes de cirugía de cataratas" loading="lazy" decoding="async">
              <div class="comparison__after" aria-hidden="true">
                <img src="/assets/case-after-cataratas-web.jpg" alt="" loading="lazy" decoding="async">
              </div>
              <div class="comparison__divider" aria-hidden="true"></div>
              <div class="comparison__handle" aria-hidden="true">
                <span class="comparison__arrow comparison__arrow--left"></span>
                <span class="comparison__arrow comparison__arrow--right"></span>
              </div>
              <input class="comparison__range" type="range" min="0" max="100" value="50" aria-label="Deslizar segundo caso antes y después de cirugía de pterigión">
            </div>
            <div class="result-card__body">
              <h3>Cirugía de Pterigión</h3>
              <p>Removimos satisfactoriamente la carnosidad del paciente, devolviendo una visión nítida y comodidad ocular.</p>
            </div>
          </article>
        </div>

        <a class="pill-button" href="#casos">
          <span>Ver más casos de exito</span>
          <img src="/assets/figma-icon-arrow-v2.svg" alt="">
        </a>
      </section>

      <section class="section blog-section reveal-section" id="blog" aria-labelledby="blog-title">
        <div class="section-title section-title--split">
          <h2 id="blog-title"><?= cms('home.blog_title', 'Información para cuidar tu salud visual') ?></h2>
          <p><?= cms('home.blog_description', 'Consejos, recomendaciones y contenido especializado de nuestros profesionales para ayudarte a cuidar tu visión.') ?></p>
        </div>

        <?php if ($homePosts): ?>
        <div class="blog-layout">
          <?php $featured = array_shift($homePosts); ?>
          <a class="blog-featured-card" href="/blog/<?= rawurlencode($featured['slug']) ?>" aria-label="Leer artículo: <?= e($featured['title']) ?>">
            <img src="<?= asset_url($featured['image_path'], 'assets/blog/examen-vista.png') ?>" alt="<?= e($featured['image_alt']) ?>">
            <div class="blog-featured-card__overlay"></div>
            <div class="blog-featured-card__content">
              <span><?= e($featured['category']) ?></span>
              <h3><?= e($featured['title']) ?></h3>
            </div>
          </a>

          <div class="blog-list">
            <?php foreach ($homePosts as $post): ?>
            <a class="blog-card" href="/blog/<?= rawurlencode($post['slug']) ?>">
              <img src="<?= asset_url($post['image_path'], 'assets/blog/examen-vista.png') ?>" alt="<?= e($post['image_alt']) ?>">
              <div class="blog-card__content">
                <span><?= e($post['category']) ?></span>
                <h3><?= e($post['title']) ?></h3>
                <small>Leer más <img src="/assets/figma-icon-arrow-v2.svg" alt=""></small>
              </div>
            </a>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>
      </section>

      <section class="section shorts-section reveal-section" aria-labelledby="shorts-title">
        <div class="section-title section-title--split">
          <h2 id="shorts-title">Tu salud visual, en pocos minutos</h2>
          <p>Consejos prácticos y respuestas a las preguntas más frecuentes sobre salud visual.</p>
        </div>

        <div class="shorts-grid">
          <iframe src="https://www.youtube.com/embed/NEfO0L9JvHU?rel=0&amp;playsinline=1&amp;origin=https%3A%2F%2Foftalvista.com.pe&amp;widget_referrer=https%3A%2F%2Foftalvista.com.pe" title="Short de Oftalvista sobre salud visual" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" loading="lazy" allowfullscreen></iframe>
          <iframe src="https://www.youtube.com/embed/E5elHJH2zqM?rel=0&amp;playsinline=1&amp;origin=https%3A%2F%2Foftalvista.com.pe&amp;widget_referrer=https%3A%2F%2Foftalvista.com.pe" title="Short de Oftalvista con recomendación oftalmológica" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" loading="lazy" allowfullscreen></iframe>
          <iframe src="https://www.youtube.com/embed/sS3pW2PPohs?rel=0&amp;playsinline=1&amp;origin=https%3A%2F%2Foftalvista.com.pe&amp;widget_referrer=https%3A%2F%2Foftalvista.com.pe" title="Short de Oftalvista con consejo de salud visual" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" loading="lazy" allowfullscreen></iframe>
        </div>
      </section>

      <section class="location-section reveal-section" aria-labelledby="location-title">
        <div class="location-layout">
          <div class="location-copy">
            <span class="eyebrow">Visítanos</span>
            <h2 id="location-title">Estamos cerca para cuidar tu salud visual</h2>
            <p>Encuentra nuestra clínica en Lince y recibe atención oftalmológica con la calidez y confianza que necesitas.</p>
            <div class="location-details">
              <div class="location-detail">
                <img src="/assets/figma-icon-location.svg" alt="">
                <div>
                  <strong>Dirección</strong>
                  <span>Av. Juan Pardo de Zela 437, Lince 15046</span>
                </div>
              </div>
            </div>
            <a class="location-button" href="https://maps.google.com/?q=Av.%20Juan%20Pardo%20de%20Zela%20437%2C%20Lince%2015046" target="_blank" rel="noopener">Cómo llegar</a>
          </div>
          <div class="location-map">
            <iframe src="https://www.google.com/maps?q=Av.%20Juan%20Pardo%20de%20Zela%20437%2C%20Lince%2015046&amp;output=embed" title="Mapa de ubicación de Oftalvista en Lince" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
      </section>

      <section class="personalized-section reveal-section" aria-labelledby="personalized-title">
        <div class="personalized-card">
          <img src="/assets/figma-cta-bg.png" alt="" aria-hidden="true">
          <div class="personalized-card__content">
            <h2 id="personalized-title">Atención Personalizada para Cada Paciente</h2>
            <p>
              Desde la consulta hasta la recuperación, escuchamos tus necesidades y diseñamos planes de tratamiento adaptados a tu estilo de vida y salud visual.
            </p>
            <a class="white-cta-button" href="#contacto">
              <span class="white-cta-button__icon"><img src="/assets/figma-icon-call-white.svg" alt=""></span>
              <span>Agendar una cita</span>
            </a>
          </div>
        </div>
      </section>

      <footer class="site-footer" id="contacto">
        <div class="site-footer__inner">
          <section class="footer-brand" aria-label="Oftalvista">
            <a class="footer-logo" href="#inicio" aria-label="Oftalvista inicio">
              <img class="footer-logo__mark" src="/assets/figma-brand-mark-footer.svg" alt="">
              <img class="footer-logo__wordmark" src="/assets/figma-wordmark-v2.png" alt="">
            </a>
            <p>
              En Oftalvista, nos especializamos en el cuidado integral de la salud visual, ofreciendo atención profesional y tecnología de vanguardia para el diagnóstico y tratamiento de enfermedades oculares.
            </p>
            <h3>Lunes a Sabado</h3>
            <div class="footer-row">
              <img src="/assets/figma-icon-time.svg" alt="">
              <span>de 9:00 a.m a 7:30 p.m</span>
            </div>
          </section>

          <section class="footer-column" aria-labelledby="footer-contact-title">
            <h3 id="footer-contact-title">Información de contacto</h3>
            <a class="footer-row" href="https://wa.me/51978662299?text=Buenos%20d%C3%ADas%2C%20quisiera%20mas%20informaci%C3%B3n%20para%20una%20consulta%20oftalmol%C3%B3gica." target="_blank" rel="noopener">
              <img src="/assets/figma-icon-whatsapp.svg" alt="">
              <span>+51 978662299</span>
            </a>
            <a class="footer-row footer-row--address" href="https://maps.google.com/?q=Av.%20Juan%20Pardo%20de%20Zela%20437%2C%20Lince%2015046">
              <img src="/assets/figma-icon-location.svg" alt="">
              <span>Av. Juan Pardo de Zela 437, Lince 15046</span>
            </a>
          </section>

          <nav class="footer-column footer-nav" aria-label="Navegación del pie de página">
            <h3>Navegación</h3>
            <a href="#inicio">Inicio</a>
            <a href="/servicios">Servicios</a>
            <a href="/testimonios">Testimonios</a>
            <a href="/preguntas">Preguntas</a>
            <a href="/blog">Blog</a>
          </nav>

          <section class="footer-column footer-social" aria-labelledby="footer-social-title">
            <h3 id="footer-social-title">Síguenos en</h3>
            <a class="footer-row" href="#">
              <img src="/assets/figma-icon-tiktok.svg" alt="">
              <span>Tiktok</span>
            </a>
            <a class="footer-row" href="#">
              <img src="/assets/figma-icon-instagram.svg" alt="">
              <span>Instagram</span>
            </a>
            <a class="footer-row" href="#">
              <img src="/assets/figma-icon-facebook.svg" alt="">
              <span>Facebook</span>
            </a>
          </section>

          <nav class="footer-column footer-legal" aria-label="Legal">
            <h3>Legal</h3>
            <a href="/terminos-y-condiciones">Términos y condiciones</a>
            <a href="/politica-de-privacidad">Política de Privacidad</a>
          </nav>
        </div>
      </footer>

      <div class="subfooter">
        <p>Diseñado y desarrollado por <a href="#">Diego Mendez</a></p>
      </div>

      <a
        class="whatsapp-float"
        href="https://wa.me/51978662299?text=Buenos%20d%C3%ADas%2C%20quisiera%20mas%20informaci%C3%B3n%20para%20una%20consulta%20oftalmol%C3%B3gica."
        target="_blank"
        rel="noopener"
        aria-label="Escríbenos por WhatsApp"
      >
        <img src="/assets/figma-icon-whatsapp.svg" alt="">
      </a>
    </main>
  </body>
</html>
