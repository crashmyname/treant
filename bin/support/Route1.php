<?php
namespace Support;
use Support\View;

class Route1 {
    private $routes = [];
    private $prefix;

    public function __construct($prefix) {
        $this->routes['GET'] = [];
        $this->routes['POST'] = [];
        $this->prefix = rtrim($prefix, '/');
    }

    public function get($uri, $handler, $middlewares = []) {
        $this->routes['GET'][$uri] = ['handler' => $handler, 'middlewares' => $middlewares];
    }

    public function post($uri, $handler, $middlewares = []) {
        $this->routes['POST'][$uri] = ['handler' => $handler, 'middlewares' => $middlewares];
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
    
        if (strpos($uri, $this->prefix) === 0) {
            $uri = substr($uri, strlen($this->prefix));
        }
    
        if (isset($this->routes[$method][$uri])) {
            $route = $this->routes[$method][$uri];
            $handler = $route['handler'];
            $middlewares = $route['middlewares'];
    
            // Run middlewares
            $request = new Request();
            $this->runMiddlewares($middlewares, $request, function() use ($handler) {
                call_user_func($handler);
            });
        } else {
            // Cek apakah URI ada tetapi method tidak sesuai
            if (array_key_exists($uri, $this->routes['GET']) || array_key_exists($uri, $this->routes['POST'])) {
                // Jika route ada tetapi method tidak sesuai
                header("HTTP/1.1 405 Method Not Allowed");
                include __DIR__ . '/../../app/Handle/errors/405.php';
            } else {
                // Route tidak ditemukan
                header("HTTP/1.1 404 Not Found");
                include __DIR__ . '/../../app/Handle/errors/404.php';
            }
        }
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
