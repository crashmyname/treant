<?php
session_start();
use Support\Request;
use Support\Api;
use Support\CSRFToken;
use Support\AuthMiddleware; //<-- Penambahan Middleware atau session login
use Support\Response;
use Controller\UserController;

$request = new Request();
$api = new Api($prefix.'/api');
handleMiddleware();
$user = new UserController();
// Middleware grup 'auth'
$api->post('/login', [UserController::class, 'loginapi']); 
$api->get('/users',function() use($user){
    AuthMiddleware::checkToken();
    $user->index();
});

$api->dispatch();
?>