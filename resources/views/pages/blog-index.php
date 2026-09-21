<!doctype html><html lang="es"><head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="<?= cms('blog.description') ?>"><title><?= cms('nav.blog', 'Blog') ?> | Oftalvista</title>
  <link rel="canonical" href="<?= e(\Oftalvista\Core\Config::get('APP_URL', 'http://localhost:8080')) ?>/blog">
  <link rel="icon" type="image/png" href="/assets/favicon.png"><link rel="stylesheet" href="/assets/css/site.css"><script src="/assets/js/site.js" defer></script>
</head><body class="blog-page"><main class="page-shell">
  <?php \Oftalvista\Support\View::header('blog'); ?>
  <section class="blog-page__content" aria-labelledby="blog-page-title">
    <div class="blog-page__heading"><h1 id="blog-page-title"><?= cms('blog.title') ?></h1><p><?= cms('blog.description') ?></p></div>
    <div class="blog-page__toolbar"><p><?= count($posts) ?> <?= count($posts) === 1 ? 'artículo disponible' : 'artículos disponibles' ?></p></div>
    <div class="blog-page__grid">
      <?php foreach ($posts as $post): ?>
      <a class="blog-article-card" href="/blog/<?= rawurlencode($post['slug']) ?>">
        <img src="<?= asset_url($post['image_path'], 'assets/blog/examen-vista.png') ?>" alt="<?= e($post['image_alt']) ?>" loading="lazy">
        <div class="blog-article-card__body"><span class="blog-article-card__category"><?= e($post['category']) ?></span>
          <div class="blog-article-card__meta"><time datetime="<?= e(substr($post['published_at'], 0, 10)) ?>"><?= e((new DateTimeImmutable($post['published_at']))->format('d/m/Y')) ?></time><span><?= (int) $post['reading_minutes'] ?> minutos de lectura</span></div>
          <h2><?= e($post['title']) ?></h2><p><?= e($post['excerpt']) ?></p>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
    <?php if (!$posts): ?><p class="empty-state">Pronto publicaremos nuevos consejos para tu salud visual.</p><?php endif; ?>
  </section>
  <?php \Oftalvista\Support\View::footer(); ?>
</main></body></html>
