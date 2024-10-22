<?php
namespace Support;

class Api {
    private static $routes = [];
    private static $prefix;
    private static $groupMiddlewares = []; // Menyimpan middleware grup sementara

    // Inisialisasi API dengan prefix
    public static function init($prefix = '') {
        self::$routes['GET'] = [];
        self::$routes['POST'] = [];
        self::$prefix = rtrim($prefix, '/');
    }

    // Menambahkan rute GET dengan middleware
    public static function get($uri, $handler, $middlewares = []) {
        $middlewares = array_merge(self::$groupMiddlewares, $middlewares);
        self::$routes['GET'][$uri] = [
            'handler' => $handler,
            'middlewares' => $middlewares
        ];
        return new self; // Untuk chaining
    }

    // Menambahkan rute POST dengan middleware
    public static function post($uri, $handler, $middlewares = []) {
        $middlewares = array_merge(self::$groupMiddlewares, $middlewares);
        self::$routes['POST'][$uri] = [
            'handler' => $handler,
            'middlewares' => $middlewares
        ];
        return new self;
    }

    // Menambahkan grup middleware ke beberapa rute
    public static function group(array $middlewares, \Closure $routes) {
        self::$groupMiddlewares = $middlewares;

        call_user_func($routes);

        self::$groupMiddlewares = [];
    }

    // Dispatch routing
    public static function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = strtok($_SERVER['REQUEST_URI'], '?');

        // Hilangkan prefix dari URI jika ada
        if (strpos($uri, self::$prefix) === 0) {
            $uri = substr($uri, strlen(self::$prefix));
        }

        // Cari rute yang sesuai
        $route = self::findRoute($method, $uri);

        if ($route) {
            $handler = $route['handler'];
            $middlewares = $route['middlewares'];
            $params = $route['params'] ?? [];

            // Jalankan middleware
            foreach ($middlewares as $middleware) {
                if (is_string($middleware)) {
                    $middlewareInstance = new $middleware();
                    if (method_exists($middlewareInstance, 'handle')) {
                        $middlewareInstance->handle();
                    }
                } elseif (is_callable($middleware)) {
                    call_user_func($middleware);
                }
            }

            // Jalankan handler
            if (is_array($handler) && count($handler) === 2) {
                [$controller, $method] = $handler;
                $controllerInstance = new $controller;
                call_user_func_array([$controllerInstance, $method], $params);
            } else {
                call_user_func_array($handler, $params);
            }
        } else {
            // Tangani error 404 atau 405
            if (self::routeExists($uri)) {
                header("HTTP/1.1 405 Method Not Allowed");
                include __DIR__ . '/../../app/Handle/errors/405.php';
            } else {
                header("HTTP/1.1 404 Not Found");
                include __DIR__ . '/../../app/Handle/errors/404.php';
            }
        }
    }

    // Mencari rute berdasarkan metode dan URI
    private static function findRoute($method, $uri) {
        foreach (self::$routes[$method] as $routeUri => $route) {
            // Mencocokkan URI dengan parameter
            $routePattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $routeUri);
            if (preg_match('#^' . $routePattern . '$#', $uri, $matches)) {
                // Ambil parameter dari URI
                array_shift($matches); // Hapus elemen pertama yang merupakan keseluruhan URI yang dicocokkan
                $route['params'] = $matches; // Tambahkan parameter ke route
                return $route;
            }
        }
        return null; // Tidak ada rute yang ditemukan
    }
    

    // Cek apakah route ada
    private static function routeExists($uri) {
        return isset(self::$routes['GET'][$uri]) || isset(self::$routes['POST'][$uri]);
    }
}
?>
