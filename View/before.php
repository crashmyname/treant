<?php
require_once __DIR__ . '/bin/support/Request.php';
require_once __DIR__ . '/bin/support/View.php';
require_once __DIR__ . '/bin/support/Asset.php';
require_once __DIR__ . '/bin/support/Route.php';
require_once __DIR__ . '/Controller/UserController.php';
require_once __DIR__ . '/Model/UserModel.php';
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
    View::render('berhasil', []);
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

// switch ($action) {
//     case '/mvc/':
//         $user = $userController->index();
//         View::render('user',['user'=>$user],'layout');
//         break;
//     case '/mvc/user':
//         $userController->index();
//         break;
//     case '/mvc/adduser':
//         $userController->adduser();
//         break;
//     case '/mvc/store':
//         $userController->store($request);
//         break;
//     case '/mvc/formedit':
//         $id = $request->id ? $request->id : null;
//         $userController->getUserId(base64_decode($id));
//         break;
//     case '/mvc/update':
//         $id = $request->id ? $request->id : null;
//         $userController->update($request,$id);
//         break;
//     case '/mvc/delete':
//         $id = $request->id ? $request->id : null;
//         $userController->delete(base64_decode($id));
//         break;
//     default:
//         // include __DIR__ . '/View/home.php';
//         // View::render('home',[],'layout');
//         echo "404 Not Found";
//         break;
// }
?>