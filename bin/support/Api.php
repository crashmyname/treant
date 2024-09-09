<?php

namespace Support;
use Support\View;
use Support\Request;

class Api {
    private $api = [];
    private $prefix;

    public function __construct($prefix = '') {
        $this->api['GET'] = [];
        $this->api['POST'] = [];
        $this->prefix = rtrim($prefix, '/');
    }

    public function get($uri, $handler, $middlewares = []) {
        $this->api['GET'][$uri] = ['handler' => $handler, 'middlewares' => $middlewares];
    }

    public function post($uri, $handler, $middlewares = []) {
        $this->api['POST'][$uri] = ['handler' => $handler, 'middlewares' => $middlewares];
    }

    public function middlewareGroup($middlewares, $callback) {
        // Callback akan mendefinisikan rute-rute di dalam grup middleware ini
        $callback($this, $middlewares);
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        
        if (strpos($uri, $this->prefix) === 0) {
            $uri = substr($uri, strlen($this->prefix));
        }

        foreach ($this->api[$method] as $routeUri => $route) {
            // Ganti parameter dinamis dengan regex, misal: /users/{id} menjadi /users/([a-zA-Z0-9_-]+)
            $pattern = preg_replace('/\{[a-zA-Z]+\}/', '([a-zA-Z0-9_-]+)', $routeUri);
            $pattern = str_replace('/', '\/', $pattern);

            if (preg_match('/^' . $pattern . '$/', $uri, $matches)) {
                array_shift($matches); // Hapus match penuh
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
        View::render('errors/404', []);
    }

    private function runMiddlewares($middlewares, $request, $next) {
        $index = 0;
        $middlewareCount = count($middlewares);

        // Define the middleware handler
        $middlewareHandler = function() use ($middlewares, $request, &$index, $middlewareCount, $next) {
            if ($index < $middlewareCount) {
                $middleware = $middlewares[$index++];
                if (is_object($middleware) && method_exists($middleware, 'handle')) {
                    $middleware->handle($request, $middlewareHandler);
                } else {
                    throw new \Exception('Middleware tidak valid');
                }
            } else {
                // All middlewares are processed, proceed to the next handler
                $next();
            }
        };

        // Start middleware processing
        $middlewareHandler();
    }
}

?>