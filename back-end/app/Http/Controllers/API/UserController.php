<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Http\Requests\UserRequest;


class UserController extends Controller
{
    /* Função retorna todos os usuários cadastrados */
    public function index()
    {
        return response()->json([
            'message'   =>  'Sucesso:',
            'data'      =>  User::all()
        ], 200);
    }

    /* Mostra um usuário conforme id*/
    public function show($id)
    {
        $data = User::find($id);
        if (!$data) {
            return response()->json(['message'=> 'Usuário não encontrado', 'data' => null], 404);
        }
        return response()->json(['message' => 'success', 'data' => $data], 200);
    }

    /* Função para a criação do usuário e alteração da password com o algoritmo de hash */
    public function store(Request $request)
    {
        // Aqui seria um bom lugar para validar os dados com um UserRequest
        // Ex: public function store(UserRequest $request)
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        if ($request->hasFile('image')) {
            // O segundo parâmetro 'public' já define o disk, não precisa de array.
            $file_path = $request->file('image')->store('image', 'public');
            $data['image'] = $file_path;
        }
        $register = User::create($data);
        if (!$register) {
            return response()->json(['message' => 'Usuário não criado', 'data' => null], 404);
        }
        return response()->json(['message' => 'Usuário criado com sucesso', 'data' => $register], 201);
    }

    /* Atualiza um usuário por ID (geralmente para admins) */
    public function update($id, Request $request)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado', 'data' => null], 404);
        }

        $data = $request->except(['_method']); // Exclui o _method do FormData

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('image')) {
            // CORREÇÃO: Deleta a imagem antiga se ela existir
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            // Salva a nova imagem
            $file_path = $request->file('image')->store('image', 'public');
            $data['image'] = $file_path;
        }

        $user->update($data);
        return response()->json(['message' => 'Usuário atualizado com sucesso', 'data' => $user], 200);
    }

    /* Atualiza o usuário autenticado (seu próprio perfil) */
    public function updateUser(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Usuário não autenticado', 'data' => null], 401);
        }

        // O _method vem do "method spoofing" do formulário, é bom removê-lo.
        $data = $request->except(['_method']);

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('image')) {
            // Deleta a imagem antiga se ela existir
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            // Salva a nova imagem
            $file_path = $request->file('image')->store('image', 'public');
            $data['image'] = $file_path;
        }

        $user->update($data);
        return response()->json(['message' => 'Perfil atualizado com sucesso', 'data' => $user], 200);
    }

    /* Remove o registro do usuário */
    public function destroy($id)
    {
        $data = User::find($id);
        if (!$data) {
            return response()->json(['message' => 'Usuario não encontrado', 'data' => null], 404);
        }

        // Opcional: deletar a imagem do usuário do storage também
        if ($data->image && Storage::disk('public')->exists($data->image)) {
            Storage::disk('public')->delete($data->image);
        }

        $data->delete();
        return response()->json(['message' => 'Usuário removido com sucesso', 'data' => $data], 200);
    }
}
