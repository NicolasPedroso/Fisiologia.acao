<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Models\Register;


class RegisterController extends Controller
{
    /* Função retorna todos os usuários cadastrados */
    public function index() {
        $dados = Register::all();
        return response()->json([
            'message'=>'success',
            'data'=>$dados

        ],200);
    }

    /* Mostra um usuário conforme id*/
    public function show($id) {
        $dados = Register::find($id);
        if (!$dados)
            return response()->json(['message'=> 'usuário não encontrado', 'data' => null], 404);
        return response()->json(['message' => 'success', 'data' => $dados],200);
    }

    /* Função para a criação do usuário e alteração da password com o algoritmo de hash */
    public function store(Request $request) {
        $dados = $request->all();
        $dados['password'] = Hash::make($request->password);
        $cadastro = Register::create($dados);
        if (!$cadastro)
            return response()->json(['message' => 'Usuário não criado', 'data' => null], 404);
        return response()->json(['message' => 'Usuário criado', 'data' => $cadastro], 201);
    }

    /* Atualiza um usuário */
    public function update($id, Request $request) {
        $dados = Register::find($id);
        if (!$dados)
            return response()->json(['message' => 'Usuário nao encontrado', 'data' => null], 404);
        $cadastro = $request->all();
        if ($request->has('password'))
            $cadastro['password']= Hash::make($request->password);
        $dados->update ($cadastro);
        return response()->json(['message' => 'Usuário atualizado', 'data' => $cadastro], 200);

    }

    /* Remove o registro do usuário */
    public function destroy($id) {
        $dados = Register::find($id);
        if (!$dados)
            return response()->json(['message' => 'Usuario não encontrado', 'data' => null], 404);
        $dados->delete();
        return response()->json(['message' => 'Usuário destruído', 'data' => $dados], 200);
    }
}
