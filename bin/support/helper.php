<?php
use Support\Route;
use Support\BaseController;
    function asset($path)
    {
        $baseURL = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
        $baseDir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        $baseURL.=$_SERVER['HTTP_HOST'].$baseDir;

        return $baseURL.'public/'.$path;
    }

    function module($path)
    {
        $baseURL = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
        $baseDir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        $baseURL.=$_SERVER['HTTP_HOST'].$baseDir;

        return $baseURL.'node_modules/'.$path;
    }
    function vendor($path)
    {
        $baseURL = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
        $baseDir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        $baseURL.=$_SERVER['HTTP_HOST'].$baseDir;

        return $baseURL.'vendor/'.$path;
    }

    function base_url()
    {
        $basecontroller = new BaseController();
        return $basecontroller->base_url();
    }

    function vd($data) {
        $basecontroller = new BaseController();
        return $basecontroller->prettyPrint($data);
    }
    function route($name, $params = []) {
        return Route::route($name, $params);
    }

    function redirect($url){
        $basecontroller = new BaseController();
        return $basecontroller->redirect($url);
    }

    function sanitize($data){
        $basecontroller = new BaseController();
        return $basecontroller->sanitize($data);
    }

    function json($data, $statusCode = 200){
        $basecontroller = new BaseController();
        return $basecontroller->jsonResponse($data, $statusCode);
    }

    function uploadFile($file, $destination) {
        $basecontroller = new BaseController();
        return $basecontroller->uploadFile($file, $destination);
    }
    
    function strLimit($string, $limit = 100, $end = '...') {
        $basecontroller = new BaseController();
        return $basecontroller->strLimit($string, $limit, $end);
    }
    
    function toSlug($string) {
       $basecontroller = new BaseController();
       return $basecontroller->toSlug($string);
    }

    function arrayFlatten($array) {
        $basecontroller = new BaseController();
        return $basecontroller->arrayFlatten($array);
    }
    
    function arrayGet($array, $key, $default = null) {
        $basecontroller = new BaseController();
        return $basecontroller->arrayGet($array, $key, $default);
    }
    
    function generateRandomString($length = 10) {
        return substr(bin2hex(random_bytes($length)), 0, $length);
    }

    function toJson($data) {
        header('Content-Type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        exit();
    }
    
    function fromJson($json, $assoc = true) {
        return json_decode($json, $assoc);
    }

    function paginate($totalItems, $perPage = 10, $page = 1, $url = '?') {
        $totalPages = ceil($totalItems / $perPage);
        $output = '<nav><ul class="pagination">';
    
        for ($i = 1; $i <= $totalPages; $i++) {
            $output .= '<li class="page-item' . ($page == $i ? ' active' : '') . '">';
            $output .= '<a class="page-link" href="' . $url . 'page=' . $i . '">' . $i . '</a>';
            $output .= '</li>';
        }
    
        $output .= '</ul></nav>';
        return $output;
    }

    function pathJoin(...$paths) {
        return preg_replace('#/+#', '/', join('/', $paths));
    }

    function rateLimit($key, $maxAttempts = 5, $seconds = 60) {
        $currentAttempts = $_SESSION[$key] ?? 0;
    
        if ($currentAttempts >= $maxAttempts) {
            return false; // Terlalu banyak percobaan
        }
    
        $_SESSION[$key] = $currentAttempts + 1;
        return true;
    }

    function generateSlug($text) {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $text), '-'));
    }

    function sortByKey($array, $key) {
        usort($array, function($a, $b) use ($key) {
            return $a[$key] <=> $b[$key];
        });
        return $array;
    }

    function htmlEscape($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    function buildUrl($base, $params = []) {
        return $base . '?' . http_build_query($params);
    }
    
    function currentUrl() {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    function formatNumber($number, $decimals = 2) {
        return number_format($number, $decimals, '.', ',');
    }

    function isValidEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    function isValidUrl($url) {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    function setFlashMessage($key, $message) {
        $_SESSION[$key] = $message;
    }
    
    function getFlashMessage($key) {
        if (isset($_SESSION[$key])) {
            $message = $_SESSION[$key];
            unset($_SESSION[$key]);
            return $message;
        }
        return null;
    }

    function encrypt($data, $key) {
        return openssl_encrypt($data, 'AES-128-ECB', $key);
    }
    
    function decrypt($data, $key) {
        return openssl_decrypt($data, 'AES-128-ECB', $key);
    }

    function arrayPluck($array, $key) {
        return array_map(function($item) use ($key) {
            return is_array($item) && isset($item[$key]) ? $item[$key] : null;
        }, $array);
    }

    function formatCurrency($amount, $currency = 'USD') {
        return $currency . ' ' . number_format($amount, 2);
    }

    function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }
    
    function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }

    function logMessage($message, $level = 'INFO') {
        $logfile = 'app.log';
        $time = date('Y-m-d H:i:s');
        file_put_contents($logfile, "[$time] [$level] $message" . PHP_EOL, FILE_APPEND);
    }

    function arrayFilterByKey($array, $key, $value) {
        return array_filter($array, function($item) use ($key, $value) {
            return isset($item[$key]) && $item[$key] === $value;
        });
    }

    function toTitleCase($string) {
        return ucwords(strtolower($string));
    }
    
    function toSentenceCase($string) {
        return ucfirst(strtolower($string));
    }

    function toUppercase($string){
        return strtoupper($string);
    }

    function toLowercase($string){
        return strtolower($string);
    }

    function crsfToken(){
        if(empty($_SESSION['csrf_token'])){
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['csrf_token'];
        $csrf = "<input type='hidden' name='csrf_token' value='{$token}'>";
        return $csrf;
    }

    function verifyCsrfToken($token){
        return $token === $_SESSION['csrf_token'];
    }
    
    function setSecurityHeaders() {
        header("Content-Security-Policy-Report-Only: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com;");
        header("X-Content-Type-Options: nosniff");
        header("X-Frame-Options: SAMEORIGIN");
        header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
    }

    function back() {
        // Cek apakah ada referer, jika ada maka kembalikan ke halaman sebelumnya
        if (isset($_SERVER['HTTP_REFERER'])) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            // Jika tidak ada referer, arahkan ke halaman default (misalnya homepage)
            header("Location: /");
            exit();
        }
    }
    

?>