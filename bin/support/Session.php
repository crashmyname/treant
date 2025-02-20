<?php
namespace Support;
use Support\User;

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
        session_unset();
        session_destroy();
    }

    public static function unset($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
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
            // return (object) self::get('user');
            return new User(self::get('user'));
        }
        return null;
    }

    public static function flash($key, $value = null) {
        if ($value !== null) {
            $_SESSION['flash'][$key] = $value;
        } else {
            // Mengambil flash session
            $flashValue = $_SESSION['flash'][$key] ?? null;
            if (isset($_SESSION['flash'][$key])) {
                unset($_SESSION['flash'][$key]); // Hapus setelah diakses
            }
            return $flashValue;
        }
    }

    public static function hasFlash($key) {
        return isset($_SESSION['flash'][$key]);
    }
}
