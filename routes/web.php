<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () {
    return view('index');
});

$router->get('/login', function () {
    return view('login');
});

$router->get('/register', function () {
    return view('register');
});

$router->post('/register', 'AuthController@register');
$router->post('/login', 'AuthController@login');
