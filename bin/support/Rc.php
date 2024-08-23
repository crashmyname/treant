<?php
use Support\View;
use Support\RateLimiter;
use Support\CORSMiddleware;

// Fungsi untuk menangani rate limiting dan CORS
function handleMiddleware() {
    $rateLimiter = new RateLimiter();
    if (!$rateLimiter->check($_SERVER['REMOTE_ADDR'])) {
        http_response_code(429);
        View::render('errors/429', []);
        exit();
    }
    
    CORSMiddleware::handle();
}
?>
