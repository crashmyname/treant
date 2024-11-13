<?php

namespace Support;

class BaseController {
    
    public function prettyPrint($data)
    {
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

    public function redirect($url)
    {
        header('Location: '.$url);
        exit();
    }

    public function sanitize($data)
    {
        return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
    }

    public function jsonResponse($data, $statusCode)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit();
    }

    public function uploadFile($file, $destination)
    {
        $targetFile = $destination . basename($file["name"]);
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return $targetFile;
        }
        return false;
    }

    public function strLimit($string, $limit, $end)
    {
        return strlen($string) > $limit ? substr($string, 0, $limit) . $end : $string;
    }

    public function toSlug($string)
    {
        $string = strtolower(trim($string));
        $string = preg_replace('/[^a-z0-9-]/', '-', $string);
        $string = preg_replace('/-+/', '-', $string);
        return rtrim($string, '-');
    }

    public function arrayFlatten($flattened)
    {
        $flattened = [];
        array_walk_recursive($array, function($value) use (&$flattened) {
            $flattened[] = $value;
        });
        return $flattened;
    }

    public function base_url()
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

    public function arrayGet($array, $key, $default)
    {
        return isset($array[$key]) ? $array[$key] : $default;
    }

    public function generateRandomString($length)
    {
        return substr(bin2hex(random_bytes($length)), 0, $length);
    }

    public function toJson($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        exit();
    }
    
    public function fromJson($json, $assoc)
    {
        return json_decode($json, $assoc);
    }

    public function paginate($totalItems, $perPage, $page, $url)
    {
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

    public function pathJoin(...$paths)
    {
        return preg_replace('#/+#', '/', join('/', $paths));
    }

    public function rateLimit($key, $maxAttempts = 5, $seconds = 60)
    {
        $currentAttempts = $_SESSION[$key] ?? 0;
    
        if ($currentAttempts >= $maxAttempts) {
            return false; // Terlalu banyak percobaan
        }
    
        $_SESSION[$key] = $currentAttempts + 1;
        return true;
    }

    public function generateSlug($text)
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $text), '-'));
    }

    public function sortByKey($array, $key)
    {
        usort($array, function($a, $b) use ($key) {
            return $a[$key] <=> $b[$key];
        });
        return $array;
    }

    public function htmlEscape($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    public function buildUrl($base,$params = [])
    {
        return $base . '?' . http_build_query($params);
    }

    public function currentUrl()
    {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    public function formatNumber($number, $decimals = 2)
    {
        return number_format($number, $decimals, '.', ',');
    }

    public function csrfToken()
    {
        if(empty($_SESSION['csrf_token'])){
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['csrf_token'];
        $csrf = "<input type='hidden' name='csrf_token' value='{$token}'>";
        return $csrf;
    }

    public function verifyCsrfToken($token)
    {
        return $token === $_SESSION['csrf_token'];
    }

    public function Method($method)
    {
        return "<input type='hidden' name='_method' value='{$method}'>";
    }

    public function isValidEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function isValidUrl($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    public function setFlashMessage($key, $message)
    {
        $_SESSION[$key] = $message;
    }

    public function getFlashMessage($key)
    {
        if (isset($_SESSION[$key])) {
            $message = $_SESSION[$key];
            unset($_SESSION[$key]);
            return $message;
        }
        return null;
    }

    public function encrypt($data, $key)
    {
        return openssl_encrypt($data, 'AES-128-ECB', $key);
    }

    public function decrypt($data, $key)
    {
        return openssl_decrypt($data, 'AES-128-ECB', $key);
    }

    public function arrayPluck($array, $key)
    {
        return array_map(function($item) use ($key) {
            return is_array($item) && isset($item[$key]) ? $item[$key] : null;
        }, $array);
    }

    public function formatCurrency($amount, $currency)
    {
        return $currency . ' ' . number_format($amount, 2);
    }

    public function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function verifyPassword($password,$hash)
    {
        return password_verify($password, $hash);
    }

    public function logMessage($message, $level)
    {
        $logfile = 'app.log';
        $time = date('Y-m-d H:i:s');
        file_put_contents($logfile, "[$time] [$level] $message" . PHP_EOL, FILE_APPEND);
    }

    public function arrayFilterByKey($array,$key,$value)
    {
        return array_filter($array, function($item) use ($key, $value) {
            return isset($item[$key]) && $item[$key] === $value;
        });
    }

    public function toTitleCase($string)
    {
        return ucwords(strtolower($string));
    }

    public function toSentenceCase($string)
    {
        return ucfirst(strtolower($string));
    }

    public function toUpperCase($string)
    {
        return strtoupper($string);
    }

    public function toLowerCase($string)
    {
        return strtolower($string);
    }

    public function setSecurityHeaders()
    {
        header("Content-Security-Policy-Report-Only: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com;");
        header("X-Content-Type-Options: nosniff");
        header("X-Frame-Options: SAMEORIGIN");
        header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
    }

    public function back()
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            header("Location: /");
            exit();
        }
    }
}