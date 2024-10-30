<?php
namespace Support;

class CSRFToken {
    public static function generateToken() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        $csrf = "<input type='hidden' value='{$token}' name='csrf_token'>";
        return $csrf;
    }

    public static function validateToken($token) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token)) {
            unset($_SESSION['csrf_token']);
            return true;
        }
        return false;
    }
}
?>