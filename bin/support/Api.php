<?php
namespace Support;
use Support\View;

class Api {
    private $api = [];
    private $prefix;

    public function __construct($prefix) {
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

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
    
        if (strpos($uri, $this->prefix) === 0) {
            $uri = substr($uri, strlen($this->prefix));
        }
    
        if (isset($this->api[$method][$uri])) {
            $route = $this->api[$method][$uri];
            $handler = $route['handler'];
            $middlewares = $route['middlewares'];
    
            // Run middlewares
            $request = new Request();
            $this->runMiddlewares($middlewares, $request, function() use ($handler) {
                call_user_func($handler);
            });
        } else {
            // Cek apakah URI ada tetapi method tidak sesuai
            if (array_key_exists($uri, $this->api['GET']) || array_key_exists($uri, $this->routes['POST'])) {
                // Jika route ada tetapi method tidak sesuai
                header("HTTP/1.1 405 Method Not Allowed");
                View::render('errors/405',[]);
            } else {
                // Route tidak ditemukan
                header("HTTP/1.1 404 Not Found");
                View::render('errors/404',[]);
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
