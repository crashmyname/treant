<?php
namespace Support;

class RouteExceptionHandler
{
    public static function handle($exception)
    {
        // Cek apakah pesan kesalahan mengandung 'Class not found'
        if (strpos($exception->getMessage(), 'Class') !== false) {
            http_response_code(404);
            $message = "Controller not found: " . htmlspecialchars($exception->getMessage());
            include __DIR__ . '/../../app/View/errors/controller_not_found.php'; // Ganti dengan view error sesuai kebutuhan
            exit();
        }

        // Jika bukan kesalahan controller, gunakan metode lain jika perlu
        http_response_code(500);
        include __DIR__ . '/../../app/View/errors/500.php'; // Ganti dengan view error umum
        exit();
    }
}

?>