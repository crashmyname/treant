<?php

class Route {
    private $routes = [];
    private $prefix;

    public function __construct($prefix) {
        // Mendaftarkan rute GET
        $this->routes['GET'] = [];
        // Mendaftarkan rute POST
        $this->routes['POST'] = [];
        $this->prefix = $prefix;
    }

    public function get($uri, $handler) {
        $this->routes['GET'][$uri] = $handler;
    }

    public function post($uri, $handler) {
        $this->routes['POST'][$uri] = $handler;
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = strtok($_SERVER['REQUEST_URI'], '?'); // Menghapus query string

        $uri = str_replace($this->prefix, '', $uri);

        if (isset($this->routes[$method][$uri])) {
            $handler = $this->routes[$method][$uri];
            $handler(); // Menjalankan handler
        } else {
            echo "404 Not Found";
        }
    }
}

?>