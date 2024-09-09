<?php
session_start();
use Support\Request;
use Support\Api;
use Support\CSRFToken;
use Support\AuthMiddleware; //<-- Penambahan Middleware atau session login
use Support\Response;

$request = new Request();
$route = new Route($prefix);
handleMiddleware();

// INSERT YOUR API HERE...........

$route->dispatch();
?>