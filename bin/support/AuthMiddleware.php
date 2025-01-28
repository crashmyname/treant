<?php
namespace Support;

class AuthMiddleware
{
    public function handle() {
        // Pengecekan login
        if (!$this->checkLogin()) {
            include __DIR__ . '/../../app/Handle/errors/401.php';
            exit();
        }
        
        // Token check, jika Anda ingin juga memvalidasi token di middleware ini
        // Jika Anda hanya membutuhkan login, Anda bisa menghilangkan bagian ini.
        // if (!$this->checkToken()) {
        //     include __DIR__ . '/../../app/Handle/errors/401.php';
        //     exit();
        // }
    }

    public function checkLogin() {
        if (!\Support\Session::has('user')) {
            return false;
        }

        $session_lifetime = env('SESSION_LIFETIME')*60;
        $current_time = time();
        
        if (isset($_SESSION['login_time']) && ($current_time - $_SESSION['login_time']) > $session_lifetime) {
            session_unset();
            session_destroy();
            return false;
        }
        
        $_SESSION['login_time'] = $current_time;
        return true;
    }

    // public function checkToken() {
    //     $headers = getallheaders();

    //     // Jika tidak ada token di header
    //     if (!isset($headers['Authorization'])) {
    //         header('Content-Type: application/json');
    //         header("HTTP/1.1 401 Unauthorized");
    //         echo json_encode(['error' => 'Token tidak ditemukan']);
    //         return false;
    //     }

    //     // Ambil token dari header
    //     $authHeader = $headers['Authorization'];
    //     list($bearer, $token) = explode(' ', $authHeader);

    //     // Validasi format token
    //     if (strtolower($bearer) !== 'bearer' || empty($token)) {
    //         header('Content-Type: application/json');
    //         header("HTTP/1.1 401 Unauthorized");
    //         echo json_encode(['error' => 'Format token salah']);
    //         return false;
    //     }

    //     // Validasi token
    //     if (!isset($_SESSION['token']) || $_SESSION['token'] !== $token) {
    //         header('Content-Type: application/json');
    //         header("HTTP/1.1 401 Unauthorized");
    //         echo json_encode(['error' => 'Token tidak valid']);
    //         return false;
    //     }

    //     return true;
    // }
}
?>
