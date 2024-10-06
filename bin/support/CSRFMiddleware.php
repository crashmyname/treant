<?php
namespace Support;
use Support\CSRFToken;
use Support\View;

class CSRFMiddleware
{
    public static function handle(Request $request)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PUT' || $_SERVER['REQUEST_METHOD'] === 'DELETE' || $_SERVER['REQUEST_METHOD'] === 'PATCH') {
            if (!CSRFToken::validateToken($request->csrf_token)) {
                include __DIR__ . '/../../app/Handle/errors/505.php';
                exit(); // Menghentikan eksekusi jika token tidak valid
            }
        }
    }
}
?>