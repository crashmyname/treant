<?php
use Support\View;
use Support\RateLimiter;
use Support\CORSMiddleware;
use Support\SessionMiddleware;

// Fungsi untuk menangani rate limiting dan CORS
function handleMiddleware() {
    SessionMiddleware::start();
    $rateLimiter = new RateLimiter();
    if (!$rateLimiter->check($_SERVER['REMOTE_ADDR'])) {
        http_response_code(429);
        include __DIR__ . '/../../app/Handle/errors/429.php';
        exit();
    }
    
    CORSMiddleware::handle();
}
