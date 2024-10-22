<?php

namespace Support;

class Api {
    private $api = [];
    private $prefix;

    public function __construct($prefix = '') {
        $this->api['GET'] = [];
        $this->api['POST'] = [];
        $this->prefix = rtrim($prefix, '/');
    }

    public function get($uri, $handler, $middlewares = []) {
        // Simpan route GET
        $this->api['GET'][$uri] = ['handler' => $handler, 'middlewares' => $middlewares];
    }

    public function post($uri, $handler, $middlewares = []) {
        // Simpan route POST
        $this->api['POST'][$uri] = ['handler' => $handler, 'middlewares' => $middlewares];
    }

    public function middlewareGroup($middlewares, $callback) {
        // Simpan rute-rute yang sudah ada
        $currentApi = $this->api;
    
        // Definisikan rute-rute baru dalam grup middleware
        $callback($this);
    
        // Tambahkan middleware grup ke setiap rute yang baru saja didaftarkan
        foreach ($this->api['GET'] as $uri => &$route) {
            if (!isset($currentApi['GET'][$uri])) {
                $route['middlewares'] = array_merge($middlewares, $route['middlewares']);
            }
        }
    
        foreach ($this->api['POST'] as $uri => &$route) {
            if (!isset($currentApi['POST'][$uri])) {
                $route['middlewares'] = array_merge($middlewares, $route['middlewares']);
            }
        }
    }
    

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = strtok($_SERVER['REQUEST_URI'], '?'); // Mendapatkan URI tanpa query string
    
        // Cek apakah URI memiliki prefix, jika iya, hapus prefix dari URI
        if (strpos($uri, $this->prefix) === 0) {
            $uri = substr($uri, strlen($this->prefix));
        }
    
        // Debug: Cetak rute yang tersedia
        error_log("Available Routes: " . print_r($this->api, true));
    
        // Iterasi melalui rute yang didaftarkan untuk mencocokkan dengan URI
        foreach ($this->api[$method] as $routeUri => $route) {
            // Ubah parameter seperti {id} menjadi regex
            $pattern = preg_replace('/\{[a-zA-Z]+\}/', '([a-zA-Z0-9_-]+)', $routeUri);
            $pattern = str_replace('/', '\/', $pattern);
    
            if (preg_match('/^' . $pattern . '$/', $uri, $matches)) {
                array_shift($matches); // Hapus match penuh (0-index)
    
                $handler = $route['handler'];
                $middlewares = $route['middlewares'];
    
                // Jika handler adalah array [ControllerClass, 'method'], instansiasi controller
                if (is_array($handler) && class_exists($handler[0]) && method_exists($handler[0], $handler[1])) {
                    $controller = new $handler[0]; // Instansiasi kelas controller
                    $method = $handler[1]; // Ambil nama metode
                    $handler = [$controller, $method]; // Buat handler dari instansi controller dan metode
                }
    
                // Jalankan middleware dan handler
                $request = new Request();
                $this->runMiddlewares($middlewares, $request, function() use ($handler, $matches) {
                    call_user_func_array($handler, $matches); // Kirim parameter ke handler
                });
                return;
            }
        }
    
        // Jika tidak ada rute yang cocok
        header("HTTP/1.1 404 Not Found");
        include __DIR__ . '/../../app/Handle/errors/404.php';
    }
    
    private function runMiddlewares($middlewares, $request, $next) {
        $index = 0;
        $middlewareCount = count($middlewares);
    
        error_log("Middleware Count: $middlewareCount");
    
        $middlewareHandler = function() use (&$index, $middlewares, $request, $next, $middlewareCount) {
            error_log("Processing middleware index: $index with count: $middlewareCount");
    
            if ($index < $middlewareCount) {
                $middleware = $middlewares[$index++];
                if (is_string($middleware) && class_exists($middleware)) {
                    $middleware = new $middleware;
                }
    
                if (is_object($middleware) && method_exists($middleware, 'handle')) {
                    $middleware->handle($request, $middlewareHandler);
                } else {
                    throw new \Exception('Middleware tidak valid');
                }
            } else {
                $next();
            }
        };
    
        $middlewareHandler();
    }
    
    
}
?>
