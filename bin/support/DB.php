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
        if (self::$conn === null) {
            self::$conn = Database::getConnection();
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

    public function lockForUpdate()
    {
        $this->query .= ' FOR UPDATE';
        return $this;
    }

    public function sharedLock()
    {
        $this->query .= ' LOCK IN SHARE MODE';
        return $this;
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

    public function get($fetchStyle = PDO::FETCH_OBJ)
    {
        $stmt = self::getConnection()->prepare($this->query);
        $stmt->execute($this->params);
        return $stmt->fetchAll($fetchStyle);
    }

    public function first($fetchStyle = PDO::FETCH_OBJ)
    {
        $stmt = self::getConnection()->prepare($this->query . ' LIMIT 1');
        $stmt->execute($this->params);
        return $stmt->fetch($fetchStyle);
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

    public function update($data, $whereColumn = 'user_id')
    {
        // Bangun bagian SET dengan menggunakan named placeholders
        $setClause = implode(', ', array_map(fn($col) => "$col = :$col", array_keys($data)));

        // Gabungkan query UPDATE dengan bagian SET
        $this->query = "UPDATE $this->table SET $setClause";

        // Menambahkan kondisi WHERE dengan kolom yang diterima (misalnya user_id, atau kolom lain)
        if (!empty($this->params) && isset($this->params[":$whereColumn"])) {
            // Tambahkan kondisi WHERE dengan kolom yang dinamis
            $whereClause = " WHERE $whereColumn = :$whereColumn";
            $this->query .= $whereClause;
        }

        try {
            // Persiapkan query untuk eksekusi
            $stmt = self::getConnection()->prepare($this->query);

            // Bind parameter untuk bagian SET
            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            // Bind parameter untuk bagian WHERE (dinamis, menggunakan kolom yang diberikan)
            if (!empty($this->params) && isset($this->params[":$whereColumn"])) {
                // Bind parameter dinamis sesuai dengan kolom WHERE
                $stmt->bindValue(":$whereColumn", $this->params[":$whereColumn"]);
            }

            // Eksekusi query
            return $stmt->execute();
        } catch (PDOException $e) {
            self::renderError($e);
        }
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

    public static function raw($query, $params = [], $fetchStyle = PDO::FETCH_OBJ)
    {
        try {
            $pdo = self::getConnection(); // Pastikan ini mengembalikan PDO aktif
            $stmt = $pdo->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll($fetchStyle);
        } catch (PDOException $e) {
            // Log error atau tampilkan pesan yang aman
            error_log("Database Query Error: " . $e->getMessage());
            return []; // Kembalikan array kosong jika terjadi kesalahan
        }
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

    public static function fetchAll($sql, $params = [], $fetchStyle = PDO::FETCH_OBJ)
    {
        $stmt = self::query($sql, $params);
        return $stmt->fetchAll($fetchStyle);
    }

    public static function fetch($sql, $params = [], $fetchStyle = PDO::FETCH_OBJ)
    {
        $stmt = self::query($sql, $params);
        return $stmt->fetch($fetchStyle);
    }

    public static function count($sql, $params = [])
    {
        $stmt = self::query($sql, $params);
        return $stmt->rowCount();
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
            include __DIR__ . '/../../app/Handle/errors/page_error.php';
        }
        exit();
    }
}
