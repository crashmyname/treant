<?php
require_once __DIR__ . '/Controller/UserController.php';
require_once __DIR__ . '/Model/UserModel.php';
require_once __DIR__ . '/bin/support/Request.php';

$action = $_SERVER['REQUEST_URI'];
$request = new Request();
$userController = new UserController();

switch ($action) {
    case '/mvc/store':
        $userController->store($request);
        break;
    case '/mvc/update':
        $userController->update($request);
        break;
    default:
        include __DIR__ . '/View/home.php';
        break;
}
?>
