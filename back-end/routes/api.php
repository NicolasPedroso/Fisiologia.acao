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

// A Signup tem o campo password_confirmation, mesmo não aparecendo na request!!! O laravel vai verificar
// se os valores são iguais
Route::post('signup', 'API\AuthController@signup');

/* 
    Rota de cadastro:
    Realiza GET, POST, PUT, DELETE
*/

// Rota alternativa pra cadastro de usuário, aceita somente POST
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

    // A rota abaixo é a mais complexa do projeto, então coloquei comentários para ajudar o front
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

    Ou assim:
    /**
     * Criar VÁRIAS respostas de uma só vez (bulk),
     * vinculado a uma pergunta específica (via URL).
     *
     * Exemplo de body (JSON) esperado:
     * {
     *   "respostas": [
     *     { "texto": "Alternativa A", "correta": false },
     *     { "texto": "Alternativa B", "correta": true },
     *     ...
     *   ]
     * }
     */

    Route::post('perguntas/{pergunta}/respostas/bulk', [RespostaController::class, 'storeBulk']);

    // middleware de ações realizadas somente pelo admin, setado no Kernel e no middleware como CheckIsAdmin
    Route::middleware(['admin'])->group(function () {
        Route::apiResource('contato', 'API\ContactController')->only(['store','update','destroy']);

        //retorna todos os usuários existentes
        Route::get('users', 'API\UserController@index');
        //consegue mudar qualquer campo do usuário, por isso só o admin pode utilizar. Também pode mudar a senha do próprio admin,
        Route::put('user/{id}', 'API\UserController@update');
        //retorna o usuário pelo id 
        Route::get('user/{id}', 'API\UserController@show');
    });

    Route::get('logout', 'API\AuthController@logout'); 
    // retorna os campos do usuário logado
	Route::get('user', 'API\AuthController@user');
});