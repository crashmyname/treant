<?php
class Route
{
    private $routes = [];
    private $basePath;

    public function __construct($basePath = '')
    {
        $this->basePath = rtrim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']), '/');
        // echo
    }

    public function get($uri, $callback)
    {
        $fullUri = $this->basePath . '/' . ltrim($uri, '/');
        $this->addRoute('GET', $fullUri, $callback);
        return $this;
    }

    public function post($uri, $callback)
    {
        $fullUri = $this->basePath . '/' . ltrim($uri, '/');
        $this->addRoute('POST', $fullUri, $callback);
        return $this;
    }

    private function addRoute($method, $uri, $callback)
    {
        $this->routes[$method][$uri] = $callback;
    }
}
?>
