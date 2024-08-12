<?php
namespace Support;

class Route {
    private $routes = [];
    private $prefix;

    public function __construct($prefix) {
        // Mendaftarkan rute GET
        $this->routes['GET'] = [];
        // Mendaftarkan rute POST
        $this->routes['POST'] = [];
        $this->prefix = rtrim($prefix, '/');
    }

    public function get($uri, $handler) {
        $this->routes['GET'][$uri] = $handler;
    }

    public function post($uri, $handler) {
        $this->routes['POST'][$uri] = $handler;
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
    
        if (strpos($uri, $this->prefix) === 0) {
            $uri = substr($uri, strlen($this->prefix));
        }
    
        if (isset($this->routes[$method][$uri])) {
            $handler = $this->routes[$method][$uri];
            call_user_func($handler);
        } else {
            echo "404 Not Found";
        }
    }
    
}

?>