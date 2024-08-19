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
    View::render('documentation/install',[],'documentation/doc');
});
$route->get('/dokumentasi/omodel', function(){
    View::render('documentation/old-model',[],'documentation/doc');
});
$route->get('/dokumentasi/nmodel', function(){
    View::render('documentation/new-model',[],'documentation/doc');
});
$route->get('/dokumentasi/controller', function(){
    View::render('documentation/controller',[],'documentation/doc');
});
$route->get('/dokumentasi/support/asset', function(){
    View::render('documentation/support/asset',[],'documentation/doc');
});
$route->get('/dokumentasi/support/auth', function(){
    View::render('documentation/support/authmiddleware',[],'documentation/doc');
});
$route->get('/dokumentasi/support/cors', function(){
    View::render('documentation/support/cors',[],'documentation/doc');
});
$route->get('/dokumentasi/support/crypto', function(){
    View::render('documentation/support/crypto',[],'documentation/doc');
});
$route->get('/dokumentasi/support/csrf', function(){
    View::render('documentation/support/csrf',[],'documentation/doc');
});
$route->get('/dokumentasi/support/datatable', function(){
    View::render('documentation/support/datatables',[],'documentation/doc');
});
$route->get('/dokumentasi/support/date', function(){
    View::render('documentation/support/date',[],'documentation/doc');
});
$route->get('/dokumentasi/support/http', function(){
    View::render('documentation/support/http',[],'documentation/doc');
});
$route->get('/dokumentasi/support/mailer', function(){
    View::render('documentation/support/mailer',[],'documentation/doc');
});
$route->get('/dokumentasi/support/ratelimiter', function(){
    View::render('documentation/support/ratelimiter',[],'documentation/doc');
});
$route->get('/dokumentasi/support/request', function(){
    View::render('documentation/support/request',[],'documentation/doc');
});
$route->get('/dokumentasi/support/response', function(){
    View::render('documentation/support/response',[],'documentation/doc');
});
$route->get('/dokumentasi/support/uuid', function(){
    View::render('documentation/support/uuid',[],'documentation/doc');
});
$route->get('/dokumentasi/support/validator', function(){
    View::render('documentation/support/validator',[],'documentation/doc');
});
$route->get('/dokumentasi/view', function(){
    View::render('documentation/view',[],'documentation/doc');
});
$route->get('/dokumentasi/route', function(){
    View::render('documentation/route',[],'documentation/doc');
});
$route->get('/dokumentasi/env', function(){
    View::render('documentation/env',[],'documentation/doc');
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