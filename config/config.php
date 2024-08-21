<?php
namespace Config;

use PDO;
use PDOException;

class Database
{
    public $conn;

    public function getConnection()
    {
        $this->conn = null;

        // Nilai default untuk variabel lingkungan
        $defaultEnv = [
            'DB_HOST' => '127.0.0.1',
            'DB_PORT' => '5432',
            'DB_DATABASE' => 'defaultdb', // Gunakan nama database default
            'DB_USERNAME' => 'root',
            'DB_PASSWORD' => '',
        ];

        // Coba membaca file .env
        $envFilePath = __DIR__ . '/../.env';
        if (file_exists($envFilePath)) {
            $env = parse_ini_file($envFilePath);
            if ($env !== false) {
                foreach ($defaultEnv as $key => $value) {
                    $_ENV[$key] = isset($env[$key]) && $env[$key] !== '' ? $env[$key] : $value;
                }
            } else {
                $_ENV = $defaultEnv;
            }
        } else {
            $_ENV = $defaultEnv;
        }

        try {
            // Buat koneksi database
            $dsn = "mysql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_DATABASE']}";
            $this->conn = new PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Log kesalahan ke file log, buat file log jika tidak ada
            $logDir = __DIR__ . '/../logs';
            if (!is_dir($logDir)) {
                mkdir($logDir, 0777, true);
            }
            error_log('Connection failed: ' . $e->getMessage(), 3, $logDir . '/error.log');
            // Tampilkan pesan kesalahan yang ramah untuk pengguna
            echo 'Koneksi database gagal. Silakan cek log untuk detail lebih lanjut.<br>';
        }

        return $this->conn;
    }
}
?>
