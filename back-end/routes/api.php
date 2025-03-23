<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\FaseController;
use App\Http\Controllers\PerguntaController;
use App\Http\Controllers\RespostaController;
use App\Http\Controllers\API\CadastroController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aqui você registra as rotas da sua API. Elas são carregadas pelo
| RouteServiceProvider dentro de um grupo que contém o middleware "api".
|
*/

// // Rotas públicas de login/signup
// Route::post('login', 'API\AuthController@login');
// Route::post('signup', 'API\AuthController@signup');

// CRUD Fases
Route::apiResource('fases', FaseController::class);

/* 
    Rota de cadastro:
    Realiza GET, POST, PUT, DELETE
*/
Route::apiResource ('cadastro', 'API\CadastroController');


/* 
    Rota de cadastro:
    Realiza GET, POST, PUT, DELETE
*/
Route::apiResource ('user', 'API\UserController');
Route::apiResource ('cadastro', 'API\CadastroController');

// CRUD Perguntas
Route::apiResource('perguntas', PerguntaController::class);

// CRUD individual de Respostas
Route::apiResource('respostas', RespostaController::class);

// Rota adicional para criar múltiplas respostas de uma só vez (bulk)
// Receberá algo do tipo POST /api/perguntas/1/respostas/bulk
Route::post('perguntas/{pergunta}/respostas/bulk', [RespostaController::class, 'storeBulk']);

// // Rotas que exigem autenticação por token
// Route::middleware(['auth:api'])->group(function () {
//     Route::get('logout', 'API\AuthController@logout');
//     Route::get('user', 'API\AuthController@user');
// });
