<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use App\User;


class UserController extends Controller
{
    /* Função retorna todos os usuários cadastrados */
    public function index() {
        $data = User::all();
        return response()->json([
            'message'=>'success',
            'data'=>$data

        ],200);
    }

    /* Mostra um usuário conforme id*/
    public function show($id) {
        $data = User::find($id);
        if (!$data)
            return response()->json(['message'=> 'usuário não encontrado', 'data' => null], 404);
        return response()->json(['message' => 'success', 'data' => $data],200);
    }

    /* Função para a criação do usuário e alteração da password com o algoritmo de hash */
    public function store(Request $request) {
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        if ($request->hasFile('image')) {
            $file_path = $request->file('image')->store('image', ['disk' => 'public']);
            $data['image'] = $file_path;
        }
        $register = User::create($data);
        if (!$register)
            return response()->json(['message' => 'Usuário não criado', 'data' => null], 404);
        return response()->json(['message' => 'Usuário criado', 'data' => $register], 201);
    }

    /* Atualiza um usuário */
    public function update($id, Request $request) {
        $data = User::find($id);
        if (!$data)
            return response()->json(['message' => 'Usuário nao encontrado', 'data' => null], 404);
        $register = $request->all();
        if ($request->has('password'))
            $register['password']= Hash::make($request->password);
        if ($request->hasFile('image')) {
            if (Storage::exist ('/public/' . $request->image)) {
                Storage::delete ('/public/' . $request->image);
            }
            $file_path = $request->file('image')->store('image', ['disk' => 'public']);
            $data['image'] = $file_path;
        }
        $data->update ($register);
        return response()->json(['message' => 'Usuário atualizado', 'data' => $register], 200);

    }

    /* Remove o registro do usuário */
    public function destroy($id) {
        $data = User::find($id);
        if (!$data)
            return response()->json(['message' => 'Usuario não encontrado', 'data' => null], 404);
        $data->delete();
        return response()->json(['message' => 'Usuário destruído', 'data' => $data], 200);
    }
}