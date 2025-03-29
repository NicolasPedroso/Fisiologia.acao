<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;

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
Route::post('signup', 'API\AuthController@signup');

/* 
    Rota de cadastro:
    Realiza GET, POST, PUT, DELETE
*/

// Rota alternativa pra cadastro de usuário, aceita o POST
Route::apiResource ('user', 'API\UserController');

// CRUD Perguntas

// Route::apiResource('perguntas', PerguntaController::class);

// // CRUD individual de Respostas
// Route::apiResource('respostas', RespostaController::class);

// // Rota adicional para criar múltiplas respostas de uma só vez (bulk)
// // Receberá algo do tipo POST /api/perguntas/1/respostas/bulk
// Route::post('perguntas/{pergunta}/respostas/bulk', [RespostaController::class, 'storeBulk']);

// // Rotas que exigem autenticação por token
Route::middleware(['auth:api'])->group(function () {
    Route::apiResource ('contato', 'API\ContactController')->only(['show','index']);

    // middleware de ações realizadas somente pelo admin, setado no Kernel e no middleware como CheckIsAdmin
    Route::middleware(['admin'])->group(function () {
        Route::apiResource('contato', 'API\ContactController')->only(['store','update','destroy']);

        //retorna todos os usuários existentes
        Route::get('users', 'API\UserController@index');
        //consegue mudar qualquer campo do usuário
        Route::put('user/{id}', 'API\UserController@update');
        //retorna o usuário pelo id 
        Route::get('user/{id}', 'API\UserController@show');
    });

    Route::get('logout', 'API\AuthController@logout');
    //retorna os dados do usuário logado, 
	// Route::get('user', 'API\AuthController@user');
});