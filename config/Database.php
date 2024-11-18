<?php
namespace Config;

use PDO;
use PDOException;

class Database
{
    private static $conn;
    private static $connectionPool = [];

    public static function init()
    {
        self::loadEnv();
    }

    public static function getConnectionByDatabase($databaseName)
    {
        if (!isset(self::$connectionPool[$databaseName])) {
            self::setDatabaseConfig($databaseName);
            self::$connectionPool[$databaseName] = self::$conn;
        }
        return self::$connectionPool[$databaseName];
    }

    public static function getConnection()
    {
        if (self::$conn === null) {
            self::setDatabaseConfig('default');
        }
        return self::$conn;
    }

    private static function setDatabaseConfig($databaseName)
    {
        $config = $databaseName === 'default' ? self::getDefaultConfig() : self::getCustomConfig($databaseName);
        self::connect($config);
    }

    private static function connect($config)
    {
        try {
            $dsn = self::getDsn($config);
            self::$conn = new PDO($dsn, $config['DB_USERNAME'], $config['DB_PASSWORD']);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::setDbEncoding($config['DB_CONNECTION']);
        } catch (PDOException $e) {
            self::handleConnectionError($e);
        }
    }

    private static function getDefaultConfig()
    {
        return [
            'DB_CONNECTION' => $_ENV['DB_CONNECTION'] ?? 'mysql',
            'DB_HOST' => $_ENV['DB_HOST'] ?? '127.0.0.1',
            'DB_PORT' => $_ENV['DB_PORT'] ?? '3306',
            'DB_DATABASE' => $_ENV['DB_DATABASE'] ?? 'defaultdb',
            'DB_USERNAME' => $_ENV['DB_USERNAME'] ?? 'root',
            'DB_PASSWORD' => $_ENV['DB_PASSWORD'] ?? '',
        ];
    }

    private static function getCustomConfig($databaseName)
    {
        return [
            'DB_CONNECTION' => $_ENV['DB_CONNECTION'] ?? 'mysql',
            'DB_HOST' => $_ENV['DB_HOST'] ?? '127.0.0.1',
            'DB_PORT' => $_ENV['DB_PORT'] ?? '3306',
            'DB_DATABASE' => $_ENV['DB_CUSTOM_DINAMIS'] ?? 'custom_db',
            'DB_USERNAME' => $_ENV['DB_USERNAME'] ?? 'root',
            'DB_PASSWORD' => $_ENV['DB_PASSWORD'] ?? '',
        ];
    }

    private static function getDsn($config)
    {
        $connection = $config['DB_CONNECTION'];
        switch ($connection) {
            case 'mysql':
                return "mysql:host={$config['DB_HOST']};port={$config['DB_PORT']};dbname={$config['DB_DATABASE']}";
            case 'pgsql':
                return "pgsql:host={$config['DB_HOST']};port={$config['DB_PORT']};dbname={$config['DB_DATABASE']}";
            case 'sqlsrv':
                return "sqlsrv:Server={$config['DB_HOST']},{$config['DB_PORT']};Database={$config['DB_DATABASE']}";
            case 'sqlite':
                return "sqlite:{$config['DB_DATABASE']}";
            default:
                throw new PDOException("Unsupported database connection type: {$connection}");
        }
    }

    private static function setDbEncoding($connection)
    {
        switch (strtolower($connection)) {
            case 'mysql':
                self::$conn->exec('SET NAMES utf8mb4');
                break;
            case 'pgsql':
                self::$conn->exec("SET client_encoding TO 'UTF8'");
                break;
            default:
                break;
        }
    }

    public static function handleConnectionError($exception)
    {
        $logDir = __DIR__ . '/../logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }
        error_log('Connection failed: ' . $exception->getMessage(), 3, $logDir . '/error.log');
        self::renderError($exception);
    }

    public static function renderError($exception)
    {
        static $errorDisplayed = false;
        if (!$errorDisplayed) {
            $errorDisplayed = true;
            if (!headers_sent()) {
                http_response_code(500);
            }
            $exceptionData = [
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ];
            extract($exceptionData);
            include __DIR__ . '/../app/Handle/errors/page_error.php';
        }
        exit();
    }

    private static function loadEnv()
    {
        $envFilePath = __DIR__ . '/../.env';
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

Database::init();


?>
