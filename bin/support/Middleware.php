<?php
namespace Support;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Support\View;

class Middleware
{
    public function __construct()
    {
        // Memanggil loadEnv() untuk memastikan variabel lingkungan dimuat
        self::loadEnv();
    }
    
    public function handle() {
        if (!$this->checkToken()) {
            // Include error handling page (optional)
            header("HTTP/1.1 401 Unauthorized");
            echo json_encode(['error' => 'Token tidak valid atau tidak ditemukan']);
            exit();
        }
    }

    public function checkToken() {
        $headers = getallheaders();
    
        // Jika tidak ada token di header
        if (!isset($headers['Authorization'])) {
            header('Content-Type: application/json');
            header("HTTP/1.1 401 Unauthorized");
            echo json_encode(['error' => 'Token tidak ditemukan']);
            return false;
        }
    
        // Ambil token dari header
        $authHeader = $headers['Authorization'];
        $token = substr($authHeader, 7);  // Mengambil token setelah 'Bearer '
        
        // Validasi panjang token
        if (strlen($token) > 128) {
            // Jika token lebih panjang dari 128 karakter, anggap ini adalah JWT
            return $this->validateJWT($token);
        } else {
            // Jika token lebih pendek atau kurang dari 128 karakter, anggap ini adalah Bearer biasa
            return $this->validateBearer($token);
        }
    }

    // Fungsi untuk memvalidasi Bearer Token biasa
    private function validateBearer($token) {
        // Validasi Bearer token (misalnya, periksa dengan session atau lainnya)
        if (!isset($_SESSION['token']) || $_SESSION['token'] !== $token) {
            header('Content-Type: application/json');
            header("HTTP/1.1 401 Unauthorized");
            echo json_encode(['error' => 'Bearer Token tidak valid']);
            return false;
        }
        
        return true;
    }

    // Fungsi untuk memvalidasi JWT
    private function validateJWT($token) {
        try {
            // Decode JWT token
            $decoded = JWT::decode($token, new Key($_ENV['JWT_SECRET'], 'HS256'));
            $_SESSION['user'] = $decoded;  // Simpan informasi user dari JWT
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            header("HTTP/1.1 401 Unauthorized");
            echo json_encode(['error' => 'JWT Token tidak valid', 'message' => $e->getMessage()]);
            return false;
        }
        
        return true;
    }

    // Fungsi untuk load env
    private static function loadEnv()
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
}


