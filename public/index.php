<?php
use App\Core;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../includes/bootstrap.php';

try {
    $core = new Core;
    $core->respond();
} catch (Exception $e) {
    http_response_header(500);
} finally {
    $core->shutdown();
}
