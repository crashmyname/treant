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
        $basecontroller = new BaseController();
        return $basecontroller->generateRandomString($length);
    }

    function toJson($data) {
        $basecontroller = new BaseController();
        return $basecontroller->toJson($data);
    }
    
    function fromJson($json, $assoc = true) {
        $basecontroller = new BaseController();
        return $basecontroller->fromJson($json, $assoc);
    }

    function paginate($totalItems, $perPage = 10, $page = 1, $url = '?') {
        $basecontroller = new BaseController();
        return $basecontroller->paginate($totalItems, $perPage, $page, $url);
    }

    function pathJoin(...$paths) {
        $basecontroller = new BaseController();
        return $basecontroller->pathJoin($paths);
    }

    function rateLimit($key, $maxAttempts = 5, $seconds = 60) {
        $basecontroller = new BaseController();
        return $basecontroller->rateLimit($key,$maxAttempts,$seconds);
    }

    function generateSlug($text) {
        $basecontroller = new BaseController();
        return $basecontroller->generateSlug($text);
    }

    function sortByKey($array, $key) {
        $basecontroller = new BaseController();
        return $basecontroller->sortByKey($array,$key);
    }

    function htmlEscape($string) {
        $basecontroller = new BaseController();
        return $basecontroller->htmlEscape($string);
    }

    function buildUrl($base, $params = []) {
        $basecontroller = new BaseController();
        return $basecontroller->buildUrl($base,$params);
    }
    
    function currentUrl() {
        $basecontroller = new BaseController();
        return $basecontroller->currentUrl();
    }

    function formatNumber($number, $decimals = 2) {
        $basecontroller = new BaseController();
        return $basecontroller->formatNumber($number,$decimals);
    }

    function isValidEmail($email) {
        $basecontroller = new BaseController();
        return $basecontroller->isValidEmail($email);
    }
    
    function isValidUrl($url) {
        $basecontroller = new BaseController();
        return $basecontroller->isValidUrl($url);
    }

    function setFlashMessage($key, $message) {
        $basecontroller = new BaseController();
        return $basecontroller->setFlashMessage($key,$message);
    }
    
    function getFlashMessage($key) {
        $basecontroller = new BaseController();
        return $basecontroller->getFlashMessage($key);
    }

    function encrypt($data, $key) {
        $basecontroller = new BaseController();
        return $basecontroller->encrypt($data,$key);
    }
    
    function decrypt($data, $key) {
        $basecontroller = new BaseController();
        return $basecontroller->decrypt($data,$key);
    }

    function arrayPluck($array, $key) {
        $basecontroller = new BaseController();
        return $basecontroller->arrayPluck($array,$key);
    }

    function formatCurrency($amount, $currency = 'USD') {
        $basecontroller = new BaseController();
        return $basecontroller->formatCurrency($amount,$currency);
    }

    function hashPassword($password) {
        $basecontroller = new BaseController();
        return $basecontroller->hashPassword($password);
    }
    
    function verifyPassword($password, $hash) {
        $basecontroller = new BaseController();
        return $basecontroller->verifyPassword($password,$hash);
    }

    function logMessage($message, $level = 'INFO') {
        $basecontroller = new BaseController();
        return $basecontroller->logMessage($message,$level);
    }

    function arrayFilterByKey($array, $key, $value) {
        $basecontroller = new BaseController();
        return $basecontroller->arrayFilterByKey($array,$key,$value);
    }

    function method($method){
        $basecontroller = new BaseController();
        return $basecontroller->Method($method);
    }

    function toTitleCase($string) {
        $basecontroller = new BaseController();
        return $basecontroller->toTitleCase($string);
    }
    
    function toSentenceCase($string) {
        $basecontroller = new BaseController();
        return $basecontroller->toSentenceCase($string);
    }

    function toUpperCase($string){
        $basecontroller = new BaseController();
        return $basecontroller->toUpperCase($string);
    }

    function toLowerCase($string){
        $basecontroller = new BaseController();
        return $basecontroller->toLowerCase($string);
    }

    function csrf(){
        $basecontroller = new BaseController();
        return $basecontroller->csrfToken();
    }

    function csrfToken(){
        $basecontroller = new BaseController();
        return $basecontroller->csrfMeta();
    }

    function verifyCsrfToken($token){
        $basecontroller = new BaseController();
        return $basecontroller->verifyCsrfToken($token);
    }
    
    function setSecurityHeaders() {
        $basecontroller = new BaseController();
        return $basecontroller->setSecurityHeaders();
    }

    function view($view, $data = [], $layout = null) {
        $basecontroller = new BaseController();
        return $basecontroller->view($view,$data,$layout);
    }

    function back() {
        $basecontroller = new BaseController();
        return $basecontroller->back();
    }

    function setTime(){
        date_default_timezone_set('Asia/Jakarta');
    }

    function storeFile($file, $targetDirectory)
    {
        // Cek apakah ada file yang diunggah
        if ($file['error'] === UPLOAD_ERR_OK) {
            $tmpName = $file['tmp_name'];
            $originalName = basename($file['name']);
            $targetPath = rtrim($targetDirectory, '/') . '/' . $originalName;

            // Pindahkan file dari lokasi sementara ke tujuan
            if (move_uploaded_file($tmpName, $targetPath)) {
                return ['status' => 'success', 'message' => 'File berhasil diunggah.', 'path' => $targetPath];
            } else {
                return ['status' => 'error', 'message' => 'Terjadi kesalahan saat memindahkan file.'];
            }
        } else {
            return ['status' => 'error', 'message' => 'File gagal diunggah.'];
        }
    }

    if (!function_exists('storage_path')) {
        function storage_path($path = '')
        {
            return __DIR__ . '/../../public/' . $path;
        }
    }

    function createToken()
    {
        $token = bin2hex(random_bytes(32));
        $_SESSION['token'] = $token;
        return $token;
    }

    function env()
    {
        $envFilePath = __DIR__ . '/../../.env';
        if (file_exists($envFilePath)) {
            $env = parse_ini_file($envFilePath);
            if ($env !== false) {
                foreach ($env as $key => $value) {
                    $_ENV[$key] = $value;
                }
            }
        }
    }
    