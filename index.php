<?php
require_once __DIR__ . '/autoload.php';
use Support\CORSMiddleware;
use Support\ExceptionHandler; // Tambahkan exception handler
use Support\RouteExceptionHandler; // Jika handler khusus untuk route diperlukan

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
        // Tangani rute biasa
        try {
            require_once __DIR__ . '/routes/route.php';
        } catch (\Error $e) {
            // Tangani kesalahan class tidak ditemukan
            if ($e instanceof \Error && strpos($e->getMessage(), 'Class') !== false) {
                // Tampilkan error "Controller Not Found"
                RouteExceptionHandler::handle($e);
            } else {
                // Jika bukan class tidak ditemukan, lempar ke ExceptionHandler
                ExceptionHandler::handle($e);
            }
        }
    }

} catch (\Exception $e) {
    // Jika ada Exception umum, tangani menggunakan ExceptionHandler
    ExceptionHandler::handle($e);
} catch (\Error $e) {
    // Jika ada Error (misalnya class tidak ditemukan), tangani juga
    ExceptionHandler::handle($e);
}

?>