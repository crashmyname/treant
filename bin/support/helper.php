<?php
use Support\Route;
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
        if (php_sapi_name() === 'cli-server' || PHP_SAPI === 'cli') {
            $baseURL = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
            $baseDir = rtrim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']), '/');
            $baseURL .= $_SERVER['HTTP_HOST'] . $baseDir;
            return $baseURL;
        } else {
            // URL saat menjalankan manual, periksa apakah HTTP_HOST tersedia
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
            $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
            
            // Sesuaikan dengan prefiks rute jika ada
            $baseUrl = $protocol . $host . '/' . basename(dirname(dirname(__DIR__))); 
            return $baseUrl;
        }
    }

    function pretty_print($data) {
        // Tambahkan CSS untuk memperindah tampilan
        echo '
        <style>
            .pretty-print {
                background-color: #2d2d2d;
                color: #f8f8f2;
                padding: 15px;
                border-radius: 8px;
                font-family: "Courier New", Courier, monospace;
                line-height: 1.5;
                font-size: 16px;
                max-width: 100%;
                overflow-x: auto;
            }
            .pretty-print .key {
                color: #66d9ef;
            }
            .pretty-print .string {
                color: #a6e22e;
            }
            .pretty-print .number {
                color: #fd971f;
            }
            .pretty-print .bool {
                color: #f92672;
            }
            .pretty-print .null {
                color: #75715e;
            }
            .pretty-print .collapsible {
                cursor: pointer;
                color: #f8f8f2;
                border: none;
                background: none;
                text-align: left;
            }
            .pretty-print .collapsible:after {
                content: " ▼";
            }
            .pretty-print .collapsible.active:after {
                content: " ▲";
            }
            .pretty-print .content {
                display: none;
                margin-left: 20px;
            }
            .pretty-print .content.show {
                display: block;
            }
        </style>
        ';
        
        // Tambahkan JavaScript untuk collapsible functionality
        echo '
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var coll = document.getElementsByClassName("collapsible");
                for (var i = 0; i < coll.length; i++) {
                    coll[i].addEventListener("click", function() {
                        this.classList.toggle("active");
                        var content = this.nextElementSibling;
                        if (content.style.display === "block") {
                            content.style.display = "none";
                        } else {
                            content.style.display = "block";
                        }
                    });
                }
            });
        </script>
        ';
        
        // Fungsi rekursif untuk memformat data
        function format_data($data) {
            $result = '';
    
            // Cek tipe data sebelum foreach
            if (is_array($data) || is_object($data)) {
                foreach ($data as $key => $value) {
                    $result .= '<span class="key">[' . htmlspecialchars($key) . ']</span> => ';
                    if (is_array($value) || is_object($value)) {
                        $result .= '<button class="collapsible">Object/Array</button>';
                        $result .= '<div class="content">';
                        $result .= format_data((array) $value);
                        $result .= '</div>';
                    } elseif (is_string($value)) {
                        $result .= '<span class="string">"' . htmlspecialchars($value) . '"</span><br>';
                    } elseif (is_numeric($value)) {
                        $result .= '<span class="number">' . htmlspecialchars($value) . '</span><br>';
                    } elseif (is_bool($value)) {
                        $result .= '<span class="bool">' . ($value ? 'true' : 'false') . '</span><br>';
                    } else {
                        $result .= '<span class="null">null</span><br>';
                    }
                }
            } else {
                // Jika bukan array/object, tampilkan langsung
                if (is_string($data)) {
                    $result .= '<span class="string">"' . htmlspecialchars($data) . '"</span><br>';
                } elseif (is_numeric($data)) {
                    $result .= '<span class="number">' . htmlspecialchars($data) . '</span><br>';
                } elseif (is_bool($data)) {
                    $result .= '<span class="bool">' . ($data ? 'true' : 'false') . '</span><br>';
                } else {
                    $result .= '<span class="null">null</span><br>';
                }
            }
    
            return $result;
        }
    
        // Cek tipe data utama
        if (is_object($data)) {
            // Menggunakan refleksi jika data adalah objek
            $reflection = new ReflectionClass($data);
            $properties = $reflection->getProperties();
            $formatted_data = [];
            foreach ($properties as $property) {
                $property->setAccessible(true);
                $formatted_data[$property->getName()] = $property->getValue($data);
            }
        } else {
            // Jika data adalah array atau tipe sederhana lainnya
            $formatted_data = $data;
        }
    
        // Tampilkan hasil yang sudah diformat
        echo '<div class="pretty-print">';
        echo format_data($formatted_data);
        echo '</div>';
        exit;
    }
    function route($name, $params = []) {
        return Route::route($name, $params);
    }

    function redirect($url){
        header('Location: '.$url);
        exit();
    }

    function sanitize($data){
        return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
    }

    function jsonResponse($data, $statusCode = 200){
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit();
    }

    function uploadFile($file, $destination) {
        $targetFile = $destination . basename($file["name"]);
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return $targetFile;
        }
        return false;
    }
    
    function strLimit($string, $limit = 100, $end = '...') {
        return strlen($string) > $limit ? substr($string, 0, $limit) . $end : $string;
    }
    
    function toSlug($string) {
        $string = strtolower(trim($string));
        $string = preg_replace('/[^a-z0-9-]/', '-', $string);
        $string = preg_replace('/-+/', '-', $string);
        return rtrim($string, '-');
    }

    function arrayFlatten($array) {
        $flattened = [];
        array_walk_recursive($array, function($value) use (&$flattened) {
            $flattened[] = $value;
        });
        return $flattened;
    }
    
    function arrayGet($array, $key, $default = null) {
        return isset($array[$key]) ? $array[$key] : $default;
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

?>