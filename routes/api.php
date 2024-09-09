<?php
session_start();
use Support\Request;
use Support\Api;
use Support\CSRFToken;
use Support\AuthMiddleware; //<-- Penambahan Middleware atau session login
use Support\Response;

$request = new Request();
$api = new Api('/api');
handleMiddleware();

// Middleware grup 'auth'
$route->middlewareGroup([new AuthMiddleware()], function($route) {
    $route->get('/users', [UserController::class, 'getAllUsers']); 
    $route->get('/users/{id}', [UserController::class, 'getUserById']); 
    $route->post('/users/create', [UserController::class, 'createUser']);
});

// Middleware grup 'auth-csrf'
$route->middlewareGroup([new AuthMiddleware(), new CSRFToken()], function($route) {
    $route->post('/users/update', [UserController::class, 'updateUser']);
});

$route->dispatch();
?>