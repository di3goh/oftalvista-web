<!doctype html><html lang="es"><head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="<?= e($post['meta_description'] ?: ($post['excerpt'] ?? '')) ?>"><title><?= e($post['title']) ?> | Oftalvista</title>
  <link rel="canonical" href="<?= e(\Oftalvista\Core\Config::get('APP_URL', 'http://localhost:8080')) ?>/blog/<?= rawurlencode($slug) ?>">
  <link rel="icon" href="/assets/favicon.png"><link rel="stylesheet" href="/assets/css/site.css"><script src="/assets/js/site.js" defer></script>
</head><body class="article-page"><main class="page-shell">
<?php \Oftalvista\Support\View::header('blog'); ?>
<article class="article-content">
  <nav class="article-breadcrumb" aria-label="Ruta"><a href="/">Home</a><span>&gt;</span><a href="/blog">Blog</a><span>&gt;</span><span><?= e($post['title']) ?></span></nav>
  <div class="article-hero"><img src="<?= asset_url($post['image_path'], 'assets/blog/examen-vista.png') ?>" alt="<?= e($post['image_alt']) ?>"></div>
  <header class="article-heading"><h1><?= e($post['title']) ?></h1><div class="article-meta"><time datetime="<?= e($date?->format('Y-m-d')) ?>"><?= e($date?->format('d/m/Y')) ?></time><span><?= (int) $post['reading_minutes'] ?> minutos de lectura</span><span class="article-category"><?= e($post['category']) ?></span></div></header>
  <div class="article-layout"><div class="article-body"><?= $post['body'] ?></div><aside class="article-info"><h2>Información</h2><dl><div><dt>Subido:</dt><dd><?= e($date?->format('d/m/Y')) ?></dd></div><div><dt>Autor:</dt><dd><?= e($post['author']) ?></dd></div><div><dt>Categoría:</dt><dd><?= e($post['category']) ?></dd></div><div><dt>Tiempo de lectura:</dt><dd><?= (int) $post['reading_minutes'] ?> minutos aprox.</dd></div></dl></aside></div>
</article>
<?php \Oftalvista\Support\View::footer(); ?>
</main></body></html>
