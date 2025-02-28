<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CadastroRequest;
use App\Models\Cadastro;


class CadastroController extends Controller
{
    /* Função retorna todos os usuários cadastrados */
    public function index() {
        $dados = Cadastro::all();
        return response()->json([
            'message'=>'success',
            'data'=>$dados

        ],200);
    }

    /* Mostra um usuário conforme id*/
    public function show($id) {
        $dados = Cadastro::find($id);
        if (!$dados)
            return response()->json(['message'=> 'usuário não encontrado', 'data' => null], 404);
        return response()->json(['message' => 'success', 'data' => $dados],200);
    }

    /* Função para a criação do usuário e alteração da senha com o algoritmo de hash */
    public function store(Request $request) {
        $dados = $request->all();
        $dados['senha'] = Hash::make($request->senha);
        $cadastro = Cadastro::create($dados);
        if (!$cadastro)
            return response()->json(['message' => 'Usuário não criado', 'data' => null], 404);
        return response()->json(['message' => 'Usuário criado', 'data' => $cadastro], 201);
    }

    /* Atualiza um usuário */
    public function update($id, Request $request) {
        $dados = Cadastro::find($id);
        if (!$dados)
            return response()->json(['message' => 'Usuário nao encontrado', 'data' => null], 404);
        $cadastro = $request->all();
        if ($request->has('senha'))
            $cadastro['senha']= Hash::make($request->senha);
        $dados->update ($cadastro);
        return response()->json(['message' => 'Usuário atualizado', 'data' => $cadastro], 200);

    }

    /* Remove o registro do usuário */
    public function destroy($id) {
        $dados = Cadastro::find($id);
        if (!$dados)
            return response()->json(['message' => 'Usuario não encontrado', 'data' => null], 404);
        $dados->delete();
        return response()->json(['message' => 'Usuário destruído', 'data' => $dados], 200);
    }
}
