<?php
namespace Support;

class Session {
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function get($key) {
        return $_SESSION[$key] ?? null;
    }

    public static function remove($key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public static function destroy() {
        session_destroy();
    }

    public static function has($key) {
        return isset($_SESSION[$key]);
    }

    public static function all() {
        return $_SESSION;
    }

    // Menyimpan user ke dalam sesi
    public static function user() {
        if (self::has('user')) {
            return (object) self::get('user');
        }
        return null;
    }
}

?>