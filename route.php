<?php
require_once __DIR__ . '/bin/support/Request.php';
require_once __DIR__ . '/bin/support/View.php';
require_once __DIR__ . '/bin/support/Asset.php';
require_once __DIR__ . '/Controller/UserController.php';
require_once __DIR__ . '/Model/UserModel.php';

$action = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request = new Request();
$userController = new UserController();

switch ($action) {
    case '/mvc/user':
        $userController->index();
        break;
    case '/mvc/store':
        $userController->store($request);
        break;
    case '/mvc/formedit':
        $id = $request->id ? $request->id : null;
        $userController->getUserId(base64_decode($id));
        break;
    case '/mvc/update':
        $id = $request->id ? $request->id : null;
        $userController->update($request,$id);
        break;
    case '/mvc/delete':
        $id = $request->id ? $request->id : null;
        $userController->delete(base64_decode($id));
        break;
    default:
        // include __DIR__ . '/View/home.php';
        View::render('home',[],'layout');
        break;
}
?>