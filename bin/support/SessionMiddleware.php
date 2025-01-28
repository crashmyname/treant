<?php
namespace Support;

class SessionMiddleware {
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.cookie_samesite','None');
            ini_set('session.cookie_secure',false);
            session_start([
                'cookie_lifetime' => 86400,
                'cookie_secure' => false,
                'cookie_httponly' => false,
                'cookie_samesite' => 'Lax',
            ]); // Memulai session jika belum dimulai
            if (!isset($_SESSION['csrf_token'])) {
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            }
        }
    }

    public static function regenerate() {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true); // Mengganti ID session untuk meningkatkan keamanan
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
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
    public static function validateDeviceFingerprint() {
        // Ambil IP dan User-Agent sebagai fingerprint perangkat
        $fingerprint = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
        
        // Cek apakah fingerprint yang disimpan di sesi cocok dengan fingerprint perangkat saat ini
        if (self::get('device_fingerprint') !== $fingerprint) {
            self::destroy(); // Hancurkan session jika fingerprint tidak cocok
            header("Location: /login"); // Redirect ke halaman login
            exit;
        }
    }

    // Fungsi untuk menyimpan fingerprint perangkat saat login
    public static function storeDeviceFingerprint() {
        // Simpan fingerprint perangkat saat login
        $fingerprint = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
        self::set('device_fingerprint', $fingerprint); // Menyimpan fingerprint di session
    }
}
?>
