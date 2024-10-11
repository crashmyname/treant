<?php

namespace Support;

use PDO;
use PDOException;
use Config\Database;

class DB
{
    protected static $connection;

    // Koneksi ke database menggunakan PDO
    public static function connect()
    {
        self::$connection = null;

        // Nilai default untuk variabel lingkungan
        $defaultEnv = [
            'DB_CONNECTION' => 'mysql',
            'DB_HOST' => '127.0.0.1',
            'DB_PORT' => '3306',
            'DB_DATABASE' => 'defaultdb', // Gunakan nama database default
            'DB_USERNAME' => 'root',
            'DB_PASSWORD' => '',
        ];

        // Coba membaca file .env
        $envFilePath = __DIR__ . '/../../.env';
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
            $dsn = "{$_ENV['DB_CONNECTION']}:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_DATABASE']}";
            self::$connection = new PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
            self::$connection->exec("set names utf8");
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Log kesalahan ke file log, buat file log jika tidak ada
            $logDir = __DIR__ . '/../logs';
            if (!is_dir($logDir)) {
                mkdir($logDir, 0777, true);
            }
            error_log('Connection failed: ' . $e->getMessage(), 3, $logDir . '/error.log');
            self::renderError($e);
        }

        return self::$connection;
    }

    public static function renderError($exception)
    {
        static $errorDisplayed = false;

        if (!$errorDisplayed) {
            $errorDisplayed = true;

            // Set response code menjadi 500
            if (!headers_sent()) { 
                http_response_code(500);
            }

            // Tampilkan halaman error
            $exceptionData = [
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ];
            extract($exceptionData);
            include __DIR__ . '/../src/View/errors/page_error.php';
        }
        exit();
    }

    // Mulai transaksi
    public static function beginTransaction()
    {
        return self::connect()->beginTransaction();
    }

    // Commit transaksi
    public static function commit()
    {
        return self::connect()->commit();
    }

    // Rollback transaksi
    public static function rollback()
    {
        return self::connect()->rollBack();
    }

    // Eksekusi query
    public static function query($sql, $params = [])
    {
        $stmt = self::connect()->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt;
    }

    // Fungsi untuk mengambil semua hasil query
    public static function fetchAll($sql, $params = [])
    {
        $stmt = self::query($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fungsi untuk mengambil satu baris hasil query
    public static function fetch($sql, $params = [])
    {
        $stmt = self::query($sql, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fungsi untuk menghitung jumlah baris hasil query
    public static function count($sql, $params = [])
    {
        $stmt = self::query($sql, $params);
        return $stmt->rowCount();
    }
}
