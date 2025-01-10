<?php

namespace Core;

class Inertia {
    private static $sharedData = [];

    // Fungsi untuk berbagi data global (contoh: user data, CSRF token)
    public static function share(array $data) {
        self::$sharedData = array_merge(self::$sharedData, $data);
    }

    // Fungsi untuk mengirim respons Inertia
    public static function render(string $component, array $props = []) {
        $data = [
            'component' => $component,
            'props' => array_merge(self::$sharedData, $props),
            'url' => $_SERVER['REQUEST_URI'],
            'version' => '1.0.0', // Versi aplikasi Anda
        ];

        // Jika request adalah Inertia request
        if (isset($_SERVER['HTTP_X_INERTIA'])) {
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            // Render HTML jika bukan Inertia request
            self::renderHtml($data);
        }

        exit;
    }

    private static function renderHtml(array $data) {
        $pageData = htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8');
        include __DIR__ . '/../src/Views/app.php'; // File layout utama
    }
}
