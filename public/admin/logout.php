<?php
declare(strict_types=1);
require dirname(__DIR__, 2) . '/bootstrap.php';

use Oftalvista\Core\Auth;
use Oftalvista\Core\Security;

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !Security::validateCsrf()) { http_response_code(405); exit('Solicitud inválida'); }
Auth::logout();
header('Location: /admin/login.php');
