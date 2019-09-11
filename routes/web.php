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

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->group(['prefix' => 'lista', 'middleware'=>'auth'], function() use ($router) {
    $router->get('', 'ListaController@list');
    $router->get('{id}', 'ListaController@get');
    $router->post('', 'ListaController@create');
    $router->delete('{id}', 'ListaController@delete');
    $router->put('{id}', 'ListaController@edit');
});

#Tem que remover a permissão para criar o primeiro usuario
$router->group(['prefix'=>'user', 'middleware'=>'auth'], function() use ($router) {
    $router->get('','UserController@list');
    $router->post('', 'UserController@create');
    $router->put('{id}','UserController@edit');
});

$router->post('auth','UserController@authenticate');
