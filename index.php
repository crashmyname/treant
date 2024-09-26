<?php
// require_once __DIR__ . '/autoload.php';
// require_once __DIR__ . '/routes/route.php';
// require_once __DIR__ . '/routes/api.php';
// use Support\CORSMiddleware;

// CORSMiddleware::handle();
require_once __DIR__ . '/autoload.php';
use Support\CORSMiddleware;
CORSMiddleware::handle();

$uri = trim($_SERVER['REQUEST_URI']);
$apiPrefix = '/' . basename(dirname(dirname(__DIR__))).'/api';
if (strpos($uri, $apiPrefix) === 0) {
    $uri = substr($uri, strlen($apiPrefix));
    require_once __DIR__ . '/routes/api.php';
} else {
    require_once __DIR__ . '/routes/route.php';
}
?>