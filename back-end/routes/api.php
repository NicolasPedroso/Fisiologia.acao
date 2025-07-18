<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\RespostaController;
use App\Http\Controllers\API\FaseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aqui você registra as rotas da sua API. Elas são carregadas pelo
| RouteServiceProvider dentro de um grupo que contém o middleware "api".
|
*/

// Rotas públicas de login/signup, ambas funcionais
Route::post('login', 'API\AuthController@login');

// A Signup tem o campo password_confirmation, mesmo não aparecendo na request!!! O laravel vai verificar
// se os valores são iguais
Route::post('signup', 'API\AuthController@signup');

// Rotas que exigem autenticação por token
Route::middleware(['auth:api'])->group(function () {
    // Route::apiResource('contato', 'API\ContactController')->only(['show','index']);
    // Route::apiResource('notificacao', 'API\NotificationIconController');

    Route::apiResource('themes', 'API\ThemeController')->only(['index', 'show']);

    // CRUD Fase. Para ter uma pergunta e resposta deve existir uma fase criada
    Route::apiResource('fase', 'API\FaseController')->only(['index', 'show']);
    Route::post('fase/{fase}/status', [FaseController::class, 'updateUserStatus']);

    // middleware de ações realizadas somente pelo admin, setado no Kernel e no middleware como CheckIsAdmin
    Route::middleware(['admin'])->group(function () {
        // Route::apiResource('contato', 'API\ContactController')->only(['store','update','destroy']);
        Route::apiResource('themes', 'API\ThemeController')->only(['store', 'update', 'destroy']);

        //retorna todos os usuários existentes
        Route::get('users', 'API\UserController@index');
        //consegue mudar qualquer campo do usuário, por isso só o admin pode utilizar. Também pode mudar a senha do próprio admin,
        Route::put('user/{id}', 'API\UserController@update');
        //retorna o usuário pelo id
        Route::get('user/{id}', 'API\UserController@show');

        Route::apiResource('fase', 'API\FaseController')->only(['store', 'update', 'destroy']);
    });

    Route::get('logout', 'API\AuthController@logout');

    // altera os dados do usuário logado
    Route::put('user_update', 'API\UserController@updateUser');

    // retorna os campos do usuário logado
	Route::get('user', 'API\AuthController@user');
});
