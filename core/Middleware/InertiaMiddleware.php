<?php

namespace Core\Middleware;

class InertiaMiddleware {
    public static function handle() {
        if (isset($_SERVER['HTTP_X_INERTIA_VERSION']) && $_SERVER['HTTP_X_INERTIA_VERSION'] !== '1.0.0') {
            header('X-Inertia-Location: ' . $_SERVER['REQUEST_URI']);
            http_response_code(409);
            exit;
        }
    }
}
