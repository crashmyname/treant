<?php
namespace Support;

class CORSMiddleware
{
    public static function handle()
    {
        setSecurityHeaders();
        error_log("Handling CORS: " . print_r($_SERVER, true));
        // Izinkan akses dari semua domain, bisa diatur menjadi domain tertentu
        header("Access-Control-Allow-Origin: *");

        // Izinkan metode HTTP tertentu
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

        // Izinkan header tertentu
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

        // Izinkan penggunaan credentials (seperti cookies)
        header("Access-Control-Allow-Credentials: true");

        // Untuk permintaan OPTIONS (pre-flight), kirim respons 200 dan hentikan eksekusi skrip
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header("HTTP/1.1 200 OK");
            exit();
        }
    }
}
?>