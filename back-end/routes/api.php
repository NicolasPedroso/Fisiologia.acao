<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::apiResource('profileIcon', 'API\ProfileIconController')->only(['index','show']);

/* 
    Rotas de autenticação.
*/
Route::middleware(['auth:api'])->group(function () {
    
    Route::get('logout', 'API\AuthController@logout');
    Route::get('user', 'API\AuthController@user');

    Route::apiResource('profileIcon','API\ProfileIconController')->only(['store','update','delete']);
    
    Route::middleware(['admin'])->group(function(){
    });
});