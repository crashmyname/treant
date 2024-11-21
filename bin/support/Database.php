<?php
namespace Support;

use PDO;
use PDOException;

class Database
{
    private static $conn = null;

    public static function getConnection()
    {
        if (self::$conn !== null) {
            return self::$conn;
        }

        $defaultEnv = [
            'DB_CONNECTION' => 'mysql',
            'DB_HOST' => '127.0.0.1',
            'DB_PORT' => '3306',
            'DB_DATABASE' => 'defaultdb',
            'DB_USERNAME' => 'root',
            'DB_PASSWORD' => '',
        ];

        $envFilePath = __DIR__ . '/../../.env';
        if (file_exists($envFilePath)) {
            $env = parse_ini_file($envFilePath);
            foreach ($defaultEnv as $key => $value) {
                $_ENV[$key] = $env[$key] ?? $value;
            }
        } else {
            $_ENV = $defaultEnv;
        }

        try {
            $dsn = "{$_ENV['DB_CONNECTION']}:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_DATABASE']}";
            self::$conn = new PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
            self::$conn->exec("set names utf8");
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            ErrorHandler::handleException($e);
        }

        return self::$conn;
    }

    // New function to execute a query with prepared statements
    public static function query($sql, $params = [])
    {
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
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

    public static function renderError($exception)
    {
        static $errorDisplayed = false;

        if (!$errorDisplayed) {
            $errorDisplayed = true;
            http_response_code(500);
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
}

?>
