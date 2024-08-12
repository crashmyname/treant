<?php
require_once __DIR__ . '/bin/support/Asset.php';
use Support\Request;
use Support\Route;
use Support\Validator;
use Support\View;
use Controller\UserController;
use Model\UserModel;
$envFile = __DIR__ . '/.env';
$env = parse_ini_file($envFile);

foreach ($env as $key => $value) {
    $_ENV[$key] = $value;
}

$prefix = $_ENV['ROUTE_PREFIX'] != null ? $_ENV['ROUTE_PREFIX'] : throw new Exception('Variabel lingkungan ROUTE_PREFIX tidak ditemukan atau kosong.');

$request = new Request();
$route = new Route($prefix);
$userController = new UserController();

// Menambahkan rute GET
$route->get('/', function(){
    View::render('wellcome/berhasil', []);
});
$route->get('/user', [$userController, 'index']);
$route->get('/adduser', [$userController, 'adduser']);
$route->get('/formedit', function() use ($userController, $request) {
    $id = $request->id ? base64_decode($request->id) : null;
    $userController->getUserId($id);
});
$route->get('/delete', function() use ($userController, $request) {
    $id = $request->id ? base64_decode($request->id) : null;
    $userController->delete($id);
});

// Menambahkan rute POST
$route->post('/store', function() use ($userController, $request) {
    $userController->store($request);
});
$route->post('/update', function() use ($userController, $request) {
    $id = $request->id ? base64_decode($request->id) : null;
    $userController->update($request, $id);
});

// Menjalankan route
$route->dispatch();
?>