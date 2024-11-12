<?php

namespace Support;

use PDO;
use PDOException;
use Config\Database;

class DB
{
    private static $conn = null;
    protected $table;
    protected $query;
    protected $params = [];
    public static function getConnection()
    {
        // Cek apakah koneksi sudah ada, jika sudah ada maka gunakan yang ada
        if (self::$conn !== null) {
            return self::$conn;
        }

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
            self::$conn = new PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
            self::$conn->exec('set names utf8');
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Log kesalahan ke file log, buat file log jika tidak ada
            $logDir = __DIR__ . '/../logs';
            if (!is_dir($logDir)) {
                mkdir($logDir, 0777, true);
            }
            error_log('Connection failed: ' . $e->getMessage(), 3, $logDir . '/error.log');
            self::renderError($e);
        }

        return self::$conn;
    }

    public static function beginTransaction()
    {
        return self::getConnection()->beginTransaction();
    }

    public static function commit()
    {
        return self::getConnection()->commit();
    }

    public static function rollback()
    {
        return self::getConnection()->rollback();
    }

    public static function table($table)
    {
        $instance = new self();
        $instance->table = $table;
        return $instance;
    }

    public function select($columns = ['*'])
    {
        $this->query = 'SELECT ' . implode(', ', $columns) . ' FROM ' . $this->table;
        return $this;
    }

    public function where($column, $operator, $value)
    {
        $placeholder = ':' . str_replace('.', '_', $column);
        $this->query .= " WHERE $column $operator $placeholder";
        $this->params[$placeholder] = $value;
        return $this;
    }

    public function get()
    {
        $stmt = self::getConnection()->prepare($this->query);
        $stmt->execute($this->params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function first()
    {
        $stmt = self::getConnection()->prepare($this->query . ' LIMIT 1');
        $stmt->execute($this->params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(fn($col) => ":$col", array_keys($data)));
        $this->query = "INSERT INTO $this->table ($columns) VALUES ($placeholders)";

        $stmt = self::getConnection()->prepare($this->query);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        return $stmt->execute();
    }

    public function update($data)
    {
        $setClause = implode(', ', array_map(fn($col) => "$col = :$col", array_keys($data)));
        $this->query = "UPDATE $this->table SET $setClause " . $this->query;

        $stmt = self::getConnection()->prepare($this->query);
        foreach (array_merge($data, $this->params) as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        return $stmt->execute();
    }

    public function delete()
    {
        $this->query = "DELETE FROM $this->table " . $this->query;

        $stmt = self::getConnection()->prepare($this->query);
        foreach ($this->params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        return $stmt->execute();
    }

    public static function raw($query, $params = [])
    {
        $stmt = self::getConnection()->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    // Eksekusi query
    public static function query($sql, $params = [])
    {
        $stmt = self::getConnection()->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt;
    }

    public static function fetchAll($sql, $params = [])
    {
        $stmt = self::query($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function fetch($sql, $params = [])
    {
        $stmt = self::query($sql, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function count($sql, $params = [])
    {
        $stmt = self::query($sql, $params);
        return $stmt->rowCount();
    }
}
