<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\RespostaController;
use App\Http\Controllers\API\FaseController;

/**
 * Rotas da API - Fisiologia em Ação
 *
 * Documentação dos principais retornos:
 * - Todas as rotas autenticadas retornam 401 se token inválido
 * - Todas as rotas admin retornam 403 se usuário não for admin
 */

/**
 * Rotas públicas (sem autenticação)
 */

// POST /api/login
// Retorna: { access_token, expires_at, admin (boolean), image }
Route::post('login', 'API\AuthController@login');

// POST /api/signup
// Retorna: { message, data: { id, name, email, address, phone, image, created_at, updated_at } }
Route::post('signup', 'API\AuthController@signup');

/**
 * Rotas autenticadas (requerem Bearer token)
 */
Route::middleware(['auth:api'])->group(function () {

    // GET /api/themes
    // Retorna: [{ id, title, description, image, created_at, updated_at }]

    // GET /api/themes/{id}
    // Retorna: { id, title, description, image, created_at, updated_at }
    Route::apiResource('themes', 'API\ThemeController')->only(['index', 'show']);

    // GET /api/fase
    // Retorna: [{ id, title, description, difficulty, theme_id, user_status, created_at, updated_at }]

    // GET /api/fase/{id}
    // Retorna: { id, title, description, difficulty, theme_id, perguntas: [...], created_at, updated_at }
    Route::apiResource('fase', 'API\FaseController')->only(['index', 'show']);

    // POST /api/fase/{fase}/status
    // Retorna: { message, user_status }
    Route::post('fase/{fase}/status', [FaseController::class, 'updateUserStatus']);

    /**
     * Rotas administrativas (requerem admin = true)
     */
    Route::middleware(['admin'])->group(function () {

        // Temas (CRUD completo para admin)
        // POST /api/themes - Retorna: { id, title, description, image, created_at, updated_at }
        // PUT /api/themes/{id} - Retorna: { id, title, description, image, updated_at }
        // DELETE /api/themes/{id} - Retorna: { message }
        Route::apiResource('themes', 'API\ThemeController')->only(['store', 'update', 'destroy']);

        // Usuários (gerenciamento)
        // GET /api/users - Retorna: [{ id, name, email, admin, image, created_at, updated_at }]
        Route::get('users', 'API\UserController@index');

        // PUT /api/user/{id} - Retorna: { message, user: {...} }
        Route::put('user/{id}', 'API\UserController@update');

        // GET /api/user/{id} - Retorna: { id, name, email, admin, image, address, phone, created_at, updated_at }
        Route::get('user/{id}', 'API\UserController@show');

        // Fases (CRUD completo para admin)
        // POST /api/fase - Retorna: { id, title, description, difficulty, theme_id, created_at, updated_at }
        // PUT /api/fase/{id} - Retorna: { message, fase: {...} }
        // DELETE /api/fase/{id} - Retorna: { message }
        Route::apiResource('fase', 'API\FaseController')->only(['store', 'update', 'destroy']);
    });

    // GET /api/logout
    // Retorna: { message: "Successfully logged out" }
    Route::get('logout', 'API\AuthController@logout');

    // PUT /api/user_update
    // Retorna: { message, user: { id, name, email, image, address, phone, updated_at } }
    Route::put('user_update', 'API\UserController@updateUser');

    // GET /api/user
    // Retorna: { id, name, email, admin, image, address, phone, created_at, updated_at }
    Route::get('user', 'API\AuthController@user');
});
