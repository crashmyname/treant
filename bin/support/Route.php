<?php
namespace Support;

use Support\View;

class Route
{
    private static $routes = [];
    private static $names = [];
    private static $prefix;
    private static $groupMiddlewares = []; // Menyimpan middleware grup sementara

    // Inisialisasi routing dengan prefix
    public static function init($prefix = '')
    {
        self::$routes['GET'] = [];
        self::$routes['POST'] = [];
        self::$prefix = rtrim($prefix, '/');
    }

    // Menambahkan rute GET dengan middleware
    public static function get($uri, $handler, $middlewares = [])
    {
        // Gabungkan middleware grup dengan middleware rute
        $middlewares = array_merge(self::$groupMiddlewares, $middlewares);
        self::$routes['GET'][$uri] = [
            'handler' => $handler,
            'middlewares' => $middlewares,
        ];
        return new self(); // Untuk chaining (agar bisa pakai name())
    }

    // Menambahkan rute POST dengan middleware
    public static function post($uri, $handler, $middlewares = [])
    {
        $middlewares = array_merge(self::$groupMiddlewares, $middlewares);
        self::$routes['POST'][$uri] = [
            'handler' => $handler,
            'middlewares' => $middlewares,
        ];
        return new self();
    }

    // Menambahkan rute PUT dengan middleware
    public static function put($uri, $handler, $middlewares = [])
    {
        $middlewares = array_merge(self::$groupMiddlewares, $middlewares);
        self::$routes['PUT'][$uri] = [
            'handler' => $handler,
            'middlewares' => $middlewares,
        ];
        return new self();
    }

    // Menambahkan rute DELETE dengan middleware
    public static function delete($uri, $handler, $middlewares = [])
    {
        $middlewares = array_merge(self::$groupMiddlewares, $middlewares);
        self::$routes['DELETE'][$uri] = [
            'handler' => $handler,
            'middlewares' => $middlewares,
        ];
        return new self();
    }

    // Menambahkan grup middleware ke beberapa rute
    public static function group(array $middlewares, \Closure $routes)
    {
        // Simpan middleware grup sementara
        self::$groupMiddlewares = $middlewares;

        // Panggil Closure untuk mendefinisikan rute dalam grup
        call_user_func($routes);

        // Reset middleware grup setelah eksekusi
        self::$groupMiddlewares = [];
    }

    public static function name($name)
    {
        // Memeriksa rute untuk GET, POST, PUT, atau DELETE
        foreach (['GET', 'POST', 'PUT', 'DELETE'] as $method) {
            if (!empty(self::$routes[$method])) {
                $lastRoute = array_key_last(self::$routes[$method]);
                self::$names[$name] = $lastRoute;

                // Debug log untuk memeriksa nama dan URI yang dipetakan
                error_log("Route name '{$name}' mapped to URI '{$lastRoute}'");

                return new self(); // Kembali ke chaining
            }
        }

        throw new \Exception("No routes found for naming '{$name}'");
    }

    // Mengambil rute berdasarkan nama dan parameter
    public static function route($name, $params = [])
    {
        if (isset(self::$names[$name])) {
            $uri = self::$names[$name];

            // Mengganti parameter {param} di URL dengan nilai dari $params
            foreach ($params as $key => $value) {
                $uri = str_replace('{' . $key . '}', $value, $uri);
            }

            // Menentukan apakah prefix harus ditambahkan
            if (php_sapi_name() === 'cli-server' || PHP_SAPI === 'cli') {
                return '/' . trim($uri, '/'); // Tidak menggunakan prefix saat dijalankan dari PHP CLI
            }

            return self::$prefix . '/' . trim($uri, '/');
        }

        throw new \Exception("Route dengan nama '{$name}' tidak ditemukan.");
    }

    // Dispatch routing
    public static function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];

        // Cek apakah ada override method (untuk PUT/DELETE) via _method
        if ($method === 'POST' && isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']); // Ubah method menjadi PUT/DELETE jika ada _method
        }

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

            // Buat instance Request
            $request = new \Support\Request();

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
                $controllerInstance = new $controller();

                // Cek apakah metode menerima request sebagai parameter
                $reflection = new \ReflectionMethod($controllerInstance, $method);
                $paramsCount = $reflection->getNumberOfParameters();

                // Mengatur parameter
                if ($paramsCount > 0) {
                    $parameters = $reflection->getParameters(); // Mendapatkan semua parameter

                    // Periksa jika parameter pertama adalah Request
                    if ($parameters[0]->getType() && $parameters[0]->getType()->getName() === 'Support\Request') {
                        array_unshift($params, $request); // Tambahkan Request sebagai parameter pertama
                    }
                }

                // Panggil metode controller dengan parameter yang sesuai
                call_user_func_array([$controllerInstance, $method], $params);
            } else {
                call_user_func_array($handler, $params);
            }
        } else {
            // Tangani error 404 atau 405
            if (self::routeExists($uri)) {
                header('HTTP/1.1 405 Method Not Allowed');
                include __DIR__ . '/../../app/Handle/errors/405.php';
            } else {
                header('HTTP/1.1 404 Not Found');
                include __DIR__ . '/../../app/Handle/errors/404.php';
            }
        }
    }

    // Mencari rute berdasarkan metode dan URI
    private static function findRoute($method, $uri)
    {
        foreach (self::$routes[$method] as $routeUri => $route) {
            // Mencocokkan URI dengan parameter
            // $routePattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $routeUri);
            $routePattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_\-]+)', $routeUri);
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
    private static function routeExists($uri)
    {
        return isset(self::$routes['GET'][$uri]) || isset(self::$routes['POST'][$uri]);
    }
}
?>
