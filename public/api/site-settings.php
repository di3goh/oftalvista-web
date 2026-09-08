<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/bootstrap.php';

use Oftalvista\Repositories\SettingsRepository;

if ($_SERVER['REQUEST_METHOD'] !== 'GET') { http_response_code(405); exit; }
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: public, max-age=300');
$allowed = ['nav.home','nav.services','nav.testimonials','nav.questions','nav.blog','header.appointment','contact.phone','contact.whatsapp','contact.address','social.tiktok','social.instagram','social.facebook'];
$settings = SettingsRepository::instance()->all();
echo json_encode(array_intersect_key($settings, array_flip($allowed)), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
