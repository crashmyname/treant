<?php
namespace Support;

class Request {
    private $data;
    private $files;

    public function __construct() {
        // Menggabungkan data GET dan POST
        $this->data = array_merge($this->sanitize($_GET), $this->sanitize($_POST));
        // Menyimpan data FILES
        $this->files = $this->sanitizeFiles($_FILES);
    }

    private function sanitize(array $data) {
        $sanitized = [];
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $sanitized[$key] = $this->sanitize($value); // Recursive sanitize for arrays
            } else {
                $sanitized[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            }
        }
        return $sanitized;
    }

    private function sanitizeFiles(array $files) {
        $sanitized = [];
        foreach ($files as $key => $file) {
            if (is_array($file['name'])) {
                // Handle multiple files
                $sanitized[$key] = [];
                foreach ($file['name'] as $index => $name) {
                    $sanitized[$key][] = [
                        'name' => htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
                        'type' => htmlspecialchars($file['type'][$index], ENT_QUOTES, 'UTF-8'),
                        'tmp_name' => htmlspecialchars($file['tmp_name'][$index], ENT_QUOTES, 'UTF-8'),
                        'error' => htmlspecialchars($file['error'][$index], ENT_QUOTES, 'UTF-8'),
                        'size' => htmlspecialchars($file['size'][$index], ENT_QUOTES, 'UTF-8')
                    ];
                }
            } else {
                // Single file
                $sanitized[$key] = [
                    'name' => htmlspecialchars($file['name'], ENT_QUOTES, 'UTF-8'),
                    'type' => htmlspecialchars($file['type'], ENT_QUOTES, 'UTF-8'),
                    'tmp_name' => htmlspecialchars($file['tmp_name'], ENT_QUOTES, 'UTF-8'),
                    'error' => htmlspecialchars($file['error'], ENT_QUOTES, 'UTF-8'),
                    'size' => htmlspecialchars($file['size'], ENT_QUOTES, 'UTF-8')
                ];
            }
        }
        return $sanitized;
    }

    public static function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    public function __get($key) {
        return $this->data[$key] ?? null;
    }

    public function all() {
        return $this->data;
    }

    public function file($key) {
        return $this->files[$key] ?? null;
    }
}
?>