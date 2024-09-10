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
$apiPrefix = $_ENV['ROUTE_PREFIX'].'/api';
if (strpos($uri, $apiPrefix) === 0) {
    $uri = substr($uri, strlen($apiPrefix));
    // echo "API URI without prefix: " . htmlspecialchars($uri) . "<br>";
    require_once __DIR__ . '/routes/api.php';
} else {
    // echo "Non-API detected: " . htmlspecialchars($uri) . "<br>";
    require_once __DIR__ . '/routes/route.php';
}
?>