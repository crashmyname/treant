<?php
namespace Support;

class SessionMiddleware {
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start([
                'cookie_lifetime' => 86400,
                'cookie_secure' => true,
                'cookie_httponly' => true,
            ]); // Memulai session jika belum dimulai
        }
    }

    public static function regenerate() {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true); // Mengganti ID session untuk meningkatkan keamanan
        }
    }

    public static function set($key, $value) {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION[$key] = $value; // Menyimpan data ke session
        }
    }

    public static function get($key) {
        return session_status() === PHP_SESSION_ACTIVE ? $_SESSION[$key] ?? null : null; // Mengambil data dari session
    }

    public static function delete($key) {
        if (session_status() === PHP_SESSION_ACTIVE && isset($_SESSION[$key])) {
            unset($_SESSION[$key]); // Menghapus data dari session
        }
    }

    public static function destroy() {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset(); // Menghapus semua data dari session
            session_destroy(); // Menghancurkan session
        }
    }
}
?>
