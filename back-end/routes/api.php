<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\RespostaController;

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
Route::post ('user', 'API\UserController@store');

// // Rotas que exigem autenticação por token
Route::middleware(['auth:api'])->group(function () {
    Route::apiResource ('contato', 'API\ContactController')->only(['show','index']);

    // CRUD Perguntas. Precisa da chave estrangeira da fase
    Route::apiResource('perguntas', 'API\PerguntaController');

    // CRUD individual de Respostas. Precisa da chave estrangeira da pergunta
    Route::apiResource('respostas', 'API\RespostaController');

    // CRUD Fase. Para ter uma pergunta e resposta deve existir uma fase criada
    Route::apiResource('fase', 'API\FaseController');

    // Rota adicional para criar múltiplas respostas de uma só vez (bulk)
    // Receberá algo do tipo POST /api/perguntas/1/respostas/bulk. Com o id da pergunta criada, crie um raw como abaixo
    /* 
    {
        "respostas": [
            {
                "texto": "Uma pergunta",
                "correta": 0
            }
        ]
    }
    */
    Route::post('perguntas/{pergunta}/respostas/bulk', [RespostaController::class, 'storeBulk']);

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
	Route::get('user', 'API\AuthController@user');
});