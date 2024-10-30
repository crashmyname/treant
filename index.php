<?php
require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/vendor/autoload.php';
use Support\CORSMiddleware;
use Support\ExceptionHandler;
use Support\RouteExceptionHandler;

// Jalankan middleware untuk menangani CORS
CORSMiddleware::handle();

try {
    // Ambil URI dan tentukan apakah akses API atau route biasa
    $uri = trim($_SERVER['REQUEST_URI']);
    $apiPrefix = '/' . basename(__DIR__) . '/api';
    
    // Cek apakah URI mengarah ke API
    if (strpos($uri, $apiPrefix) === 0) {
        $uri = substr($uri, strlen($apiPrefix));
        require_once __DIR__ . '/routes/api.php';
    } else {
        try {
            require_once __DIR__ . '/routes/route.php';
        } catch (\Error $e) {
            if ($e instanceof \Error && strpos($e->getMessage(), 'Class') !== false) {
                RouteExceptionHandler::handle($e);
            } else {
                ExceptionHandler::handle($e);
            }
        }
    }

} catch (\Exception $e) {
    ExceptionHandler::handle($e);
} catch (\Error $e) {
    ExceptionHandler::handle($e);
}

?>