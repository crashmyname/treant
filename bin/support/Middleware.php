<?php
namespace Support;
use Support\View;

class AuthMiddleware
{
    public static function checkLogin() {
        if (!isset($_SESSION['user_id'])) {
            $r = $_ENV['ROUTE_PREFIX'];
            // header('Location: '.$r.'/login');
            View::render('errors/401');
            exit();
        }
    }
}


?>