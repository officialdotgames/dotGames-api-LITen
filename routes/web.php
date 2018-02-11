<?php

use App\Libraries\LifxApi;

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
$router->group(['middleware' => ['oauth'], 'prefix' => 'v1/api'], function() use ($router) {

  $router->get('/test', function () {
      return json_encode(LifxApi::setSelectorProperity('group:AshOffice', 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', "cyan", "on", 7));
  });

  $router->post('/liten/game/start', 'GameController@StartGame');

  $router->post('/liten/game/end', 'GameController@EndGame');

  $router->post('/liten/game/generate', 'GameController@GenerateRound');

  $router->post('/liten/game/submit', 'GameController@SubmitRound');


});
