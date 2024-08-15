<?php
namespace Support;

class Request {
    private $data;

    public function __construct() {
        $this->data = array_merge($this->sanitize($_GET), $this->sanitize($_POST));
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
}
?>
