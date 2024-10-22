<?php
session_start();
use Support\Request;
use Support\Api;
use Support\CSRFToken;
use Support\AuthMiddleware; //<-- Penambahan Middleware atau session login
use Support\Response;

$request = new Request();
handleMiddleware();
Api::init($prefix.'/api');

// Your Route Api Here...

Api::dispatch();
?>