<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\Info(title="Projeto Base", version="1.0")
     *
     * @OA\SecurityScheme(
     *     type="http",
     *     description="Faça login com email e senha para obter seu token.",
     *     name="Token",
     *     in="header",
     *     scheme="bearer",
     *     bearerFormat="JWT",
     *     securityScheme="apiAuth",
     * )
     */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
