<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;
use App\User;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/signup",
     *      tags={"Login"},
     * security={
     *  {"apiAuth": {}},
     *   },
     *      summary="Cria um usuário",
     *      description="Cria um usuário do banco de dados.",
     *  @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      parameter="body",
     *      example="Ecomp",
     *      @OA\Schema(
     *           type="string"
     *      )
     * ),
     *  @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      parameter="body",
     *      example="admin@ecomp.co",
     *      @OA\Schema(
     *           type="string"
     *      )
     * ),
     *  @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      parameter="body",
     *      example="secret",
     *      @OA\Schema(
     *           type="string"
     *      )
     * ),
     *  @OA\Parameter(
     *      name="password_confirmation",
     *      in="query",
     *      required=true,
     *      parameter="body",
     *      example="secret",
     *      @OA\Schema(
     *           type="string"
     *      )
     * ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *           example={
     *                  "Usuário criado com sucesso!",
     *           }
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *              example={
     *                  "message": "Unauthorized",
     *              }
     *          ),
     *      )
     *)
     */
    /**
     * Cria um usuário
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);

        if ($validator->fails())
            return response()->json($validator->errors(), 400);

        $user = new User([
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $user->save();

        return response()->json('Usuário criado com sucesso!', 201);
    }

    /**
     * @OA\Post(
     *      path="/api/login",
     *      tags={"Login"},
     * security={
     *  {"apiAuth": {}},
     *   },
     *      summary="Faz login",
     *      description="Faz login do usuário retornando um token de acesso.",
     *  @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      parameter="body",
     *      example="admin@ecomp.co",
     *      @OA\Schema(
     *           type="string"
     *      )
     * ),
     *  @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      parameter="body",
     *      example="secret",
     *      @OA\Schema(
     *           type="string"
     *      )
     * ),
     *  @OA\Parameter(
     *      name="remember_me",
     *      in="query",
     *      required=false,
     *      parameter="body",
     *      example="1",
     *      @OA\Schema(
     *           type="bool"
     *      )
     * ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *           example={
     *              "access_token": "eyJ0eXAiOiJKV1QiLCJhbG...",
     *               "expires_at": "2020-10-28 13:11:36"
     *           }
     *      )
     *      ),
     * @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *              example={
     *                  "message": "Unauthorized",
     *              }
     *          ),
     *      )
     *  )
     */
    /**
     * Login do usuário
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'remember_me' => 'boolean'
        ]);

        if ($validator->fails())
            return response()->json($validator->errors(), 400);


        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $tokenResult = $request->user()->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * @OA\Get(
     *      path="/api/logout",
     *      tags={"Login"},
     * security={
     *  {"apiAuth": {}},
     *   },
     *      summary="Desloga um usuário",
     *      description="Desloga um usuário logado.",
     *
     * @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User"),
     *
     *  ),
     * @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *              example={
     *                  "message": "Unauthorized",
     *              }
     *          ),
     *      )
     *  )
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Usuário deslogado!'
        ]);
    }

    /**
     * @OA\Get(
     *      path="/api/user",
     *      tags={"Login"},
     * security={
     *  {"apiAuth": {}},
     *   },
     *      summary="Retorna usuário logado",
     *      description="Retorna os dados de um usuário logado.",
     *
     * @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User"),
     *
     *  ),
     * @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *              example={
     *                  "message": "Unauthorized",
     *              }
     *          ),
     *      )
     *  )
     */
    /**
     * Retorna um usuário logado.
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
