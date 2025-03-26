<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CadastroController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
    Rotas de login.
*/
Route::post('login', 'API\AuthController@login');
Route::post('signup', 'API\AuthController@signup');

/* 
    Rota de cadastro:
    Realiza GET, POST, PUT, DELETE
*/
Route::apiResource ('cadastro', 'API\CadastroController');

Route::apiResource('notification', 'API\NotificationIconController')->only('index','get','store','update','delete');


/* 
    Rotas de autenticação.
*/
Route::middleware(['auth:api'])->group(function () {

    Route::get('logout', 'API\AuthController@logout');
    Route::get('user', 'API\AuthController@user');

});