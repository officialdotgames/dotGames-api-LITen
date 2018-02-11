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

$router->post('/v1/api/register', 'AuthController@register');
$router->post('/v1/api/login', 'AuthController@login');


//Alexa OAuth Routes
$router->group(['middleware' => ['oauth'], 'prefix' => 'v1/api', 'namespace' => 'App\Http\Controllers'], function() use ($router) {

  $router->get('/test', function () {
      return "test";
  });

});
