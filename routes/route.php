<?php
use Support\Route;
use Support\View;
use Support\AuthMiddleware; //<-- Penambahan Middleware atau session login

// handleMiddleware();
Route::get('/',function(){
    View::render('welcome/welcome');
});

Route::get('/dokumentasi', function(){
    $title = "Get Started";
    View::render('documentation/install',['title'=>$title],'documentation/doc');
})->name('instalasi');
Route::get('/dokumentasi/omodel', function(){
    $title = "Old Model";
    View::render('documentation/old-model',['title'=>$title],'documentation/doc');
})->name('old-model');
Route::get('/dokumentasi/nmodel', function(){
    $title = "New Model";
    View::render('documentation/new-model',['title'=>$title],'documentation/doc');
})->name('new-model');
Route::get('/dokumentasi/controller', function(){
    $title = "Controller";
    View::render('documentation/controller',['title'=>$title],'documentation/doc');
})->name('controller');
Route::get('/dokumentasi/view', function(){
    $title = "View";
    View::render('documentation/view',['title'=>$title],'documentation/doc');
})->name('view');
Route::get('/dokumentasi/route', function(){
    $title = "Route";
    View::render('documentation/route',['title'=>$title],'documentation/doc');
})->name('route');
Route::get('/dokumentasi/env', function(){
    $title = "Env";
    View::render('documentation/env',['title'=>$title],'documentation/doc');
})->name('env');
Route::get('/dokumentasi/cli', function(){
    $title = "CLI";
    View::render('documentation/cli',['title'=>$title],'documentation/doc');
})->name('cli');
Route::get('/dokumentasi/orm', function(){
    $title = "ORM";
    View::render('documentation/orm',['title'=>$title],'documentation/doc');
})->name('orm');
Route::get('/dokumentasi/support/asset', function(){
    $title = "Asset";
    View::render('documentation/support/asset',['title'=>$title],'documentation/doc');
})->name('asset');
Route::get('/dokumentasi/support/auth', function(){
    $title = "Auth";
    View::render('documentation/support/authmiddleware',['title'=>$title],'documentation/doc');
})->name('auth');
Route::get('/dokumentasi/support/cors', function(){
    $title = "Cors";
    View::render('documentation/support/cors',['title'=>$title],'documentation/doc');
})->name('cors');
Route::get('/dokumentasi/support/crypto', function(){
    $title = "Crypto";
    View::render('documentation/support/crypto',['title'=>$title],'documentation/doc');
})->name('crypto');
Route::get('/dokumentasi/support/csrf', function(){
    $title = "CSRF";
    View::render('documentation/support/csrf',['title'=>$title],'documentation/doc');
})->name('csrf');
Route::get('/dokumentasi/support/datatable', function(){
    $title = "DataTable";
    View::render('documentation/support/datatables',['title'=>$title],'documentation/doc');
})->name('datatable');
Route::get('/dokumentasi/support/date', function(){
    $title = "Date";
    View::render('documentation/support/date',['title'=>$title],'documentation/doc');
})->name('date');
Route::get('/dokumentasi/support/http', function(){
    $title = "Http";
    View::render('documentation/support/http',['title'=>$title],'documentation/doc');
})->name('http');
Route::get('/dokumentasi/support/mailer', function(){
    $title = "Mailer";
    View::render('documentation/support/mailer',['title'=>$title],'documentation/doc');
})->name('mailer');
Route::get('/dokumentasi/support/ratelimiter', function(){
    $title = "Rate Limiter";
    View::render('documentation/support/ratelimiter',['title'=>$title],'documentation/doc');
})->name('ratelimiter');
Route::get('/dokumentasi/support/request', function(){
    $title = "Request";
    View::render('documentation/support/request',['title'=>$title],'documentation/doc');
})->name('request');
Route::get('/dokumentasi/support/response', function(){
    $title = "Response";
    View::render('documentation/support/response',['title'=>$title],'documentation/doc');
})->name('response');
Route::get('/dokumentasi/support/uuid', function(){
    $title = "UUID";
    View::render('documentation/support/uuid',['title'=>$title],'documentation/doc');
})->name('uuid');
Route::get('/dokumentasi/support/validator', function(){
    $title = "Validator";
    View::render('documentation/support/validator',['title'=>$title],'documentation/doc');
})->name('validator');
