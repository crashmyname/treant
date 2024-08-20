<?php
session_start();
require_once __DIR__ . '/bin/support/Asset.php';
require_once __DIR__ . '/bin/support/Prefix.php';
use Support\Request;
use Support\Route;
use Support\Validator;
use Support\View;
use Support\CSRFToken;
use Support\CORSMiddleware;
use Support\AuthMiddleware; //<-- Penambahan Middleware atau session login
use Support\RateLimiter;
use Support\Crypto;
use Support\UUID;
use Support\Response;
use Controller\UserController;
use Model\UserModel;

$request = new Request();
$route = new Route($prefix);
$userController = new UserController();

$rateLimiter = new RateLimiter();
if (!$rateLimiter->check($_SERVER['REMOTE_ADDR'])) {
    http_response_code(429);
    View::render('errors/429',[]);
    exit();
}
CORSMiddleware::handle();

// DOKUMENTASI
$route->get('/', function(){
    View::render('wellcome/berhasil');
});
$route->get('/dokumentasi', function(){
    $title = "Get Started";
    View::render('documentation/install',['title'=>$title],'documentation/doc');
});
$route->get('/dokumentasi/omodel', function(){
    $title = "Old Model";
    View::render('documentation/old-model',['title'=>$title],'documentation/doc');
});
$route->get('/dokumentasi/nmodel', function(){
    $title = "New Model";
    View::render('documentation/new-model',['title'=>$title],'documentation/doc');
});
$route->get('/dokumentasi/controller', function(){
    $title = "Controller";
    View::render('documentation/controller',['title'=>$title],'documentation/doc');
});
$route->get('/dokumentasi/support/asset', function(){
    $title = "Asset";
    View::render('documentation/support/asset',['title'=>$title],'documentation/doc');
});
$route->get('/dokumentasi/support/auth', function(){
    $title = "Auth";
    View::render('documentation/support/authmiddleware',['title'=>$title],'documentation/doc');
});
$route->get('/dokumentasi/support/cors', function(){
    $title = "Cors";
    View::render('documentation/support/cors',['title'=>$title],'documentation/doc');
});
$route->get('/dokumentasi/support/crypto', function(){
    $title = "Crypto";
    View::render('documentation/support/crypto',['title'=>$title],'documentation/doc');
});
$route->get('/dokumentasi/support/csrf', function(){
    $title = "CSRF";
    View::render('documentation/support/csrf',['title'=>$title],'documentation/doc');
});
$route->get('/dokumentasi/support/datatable', function(){
    $title = "DataTable";
    View::render('documentation/support/datatables',['title'=>$title],'documentation/doc');
});
$route->get('/dokumentasi/support/date', function(){
    $title = "Date";
    View::render('documentation/support/date',['title'=>$title],'documentation/doc');
});
$route->get('/dokumentasi/support/http', function(){
    $title = "Http";
    View::render('documentation/support/http',['title'=>$title],'documentation/doc');
});
$route->get('/dokumentasi/support/mailer', function(){
    $title = "Mailer";
    View::render('documentation/support/mailer',['title'=>$title],'documentation/doc');
});
$route->get('/dokumentasi/support/ratelimiter', function(){
    $title = "Rate Limiter";
    View::render('documentation/support/ratelimiter',['title'=>$title],'documentation/doc');
});
$route->get('/dokumentasi/support/request', function(){
    $title = "Request";
    View::render('documentation/support/request',['title'=>$title],'documentation/doc');
});
$route->get('/dokumentasi/support/response', function(){
    $title = "Response";
    View::render('documentation/support/response',['title'=>$title],'documentation/doc');
});
$route->get('/dokumentasi/support/uuid', function(){
    $title = "UUID";
    View::render('documentation/support/uuid',['title'=>$title],'documentation/doc');
});
$route->get('/dokumentasi/support/validator', function(){
    $title = "Validator";
    View::render('documentation/support/validator',['title'=>$title],'documentation/doc');
});
$route->get('/dokumentasi/view', function(){
    $title = "View";
    View::render('documentation/view',['title'=>$title],'documentation/doc');
});
$route->get('/dokumentasi/route', function(){
    $title = "Route";
    View::render('documentation/route',['title'=>$title],'documentation/doc');
});
$route->get('/dokumentasi/env', function(){
    $title = "Env";
    View::render('documentation/env',['title'=>$title],'documentation/doc');
});


// Authentication
$route->get('/login', function(){
    View::render('login');
});
$route->post('/login', function() use ($userController) {
    $request = new Request();
    $userController->login($request);
});
$route->post('/api/login', function() use ($userController) {
    $request = new Request();
    $userController->loginapi($request);
});
$route->get('/logout', function() use ($userController) {
    $userController->logout();
});
// User
$route->get('/user', function() use ($userController) {
    AuthMiddleware::checkLogin(); //<-- Cara pemanggilannya
    $userController->index();
});
$route->get('/user/getUsers', function() use ($userController){
    $userController->getUsers();
});
$route->get('/api/user', function() use ($userController) {
    AuthMiddleware::checkToken();
    $userController->userapi();
});
$route->get('/adduser', function() use ($userController){
    AuthMiddleware::checkLogin();
    $userController->addUser();
});
$route->get('/formedit', function() use ($userController, $request) {
    AuthMiddleware::checkLogin();
    $id = Crypto::decrypt($request->id);
    $userController->getUserId($id);
});
$route->post('/store', function() use ($userController, $request) {
    $userController->store($request);
});
$route->post('/update', function() use ($userController, $request) {
    $id = Crypto::decrypt($request->id);
    $userController->update($request, $id);
});
$route->get('/delete', function() use ($userController, $request) {
    $id = Crypto::decrypt($request->id);
    $userController->delete($id);
});

// Menjalankan route
// echo "Dispatching route...<br>";
$route->dispatch();
?>