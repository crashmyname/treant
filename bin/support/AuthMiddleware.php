<?php
namespace Support;
use Support\View;

class AuthMiddleware
{
    public static function checkLogin() {
        if (!\Support\Session::has('user')) {
            $r = $_ENV['ROUTE_PREFIX'];
            // header('Location: '.$r.'/login');
            View::render('errors/401');
            exit();
        }

        $session_lifetime = 3600;
        $current_time = time();
        if(isset($_SESSION['login_time']) && ($current_time-$_SESSION['login_time']) > $session_lifetime){
            session_unset();
            session_destroy();
            View::render('errors/401');
            exit();
        }
        $_SESSION['login_time'] = $current_time;
    }

    public static function checkToken()
    {
        // Cek apakah header Authorization ada
        $headers = getallheaders();
        
        if (!isset($headers['Authorization'])) {
            header('Content-Type: application/json');
            header("HTTP/1.1 401 Unauthorized");
            echo json_encode(['error' => 'Token tidak ditemukan']);
            exit();
        }

        // Ambil token dari header
        $authHeader = $headers['Authorization'];
        list($bearer, $token) = explode(' ', $authHeader);

        // Validasi format
        if (strtolower($bearer) !== 'bearer' || empty($token)) {
            header('Content-Type: application/json');
            header("HTTP/1.1 401 Unauthorized");
            echo json_encode(['error' => 'Format token salah']);
            exit();
        }

        // Validasi token
        if (!isset($_SESSION['token']) || $_SESSION['token'] !== $token) {
            header('Content-Type: application/json');
            header("HTTP/1.1 401 Unauthorized");
            echo json_encode(['error' => 'Token tidak valid']);
            exit();
        }
    }
}


?>