<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $link = Contact::all();
        return response()->json([
            'message' => 'sucesso',
            'data' => $link        
        ],200);
    }

    
    /**
     * Mostra um link específico pelo ID.
     */
    public function show($id)
    {
        $dados = Contact::find($id);
        if (!$dados) {
            return response()->json(['message' => 'Link não encontrado', 'data' => null], 404);
        }
        return response()->json(['message' => 'success', 'data' => $dados], 200);
    }

    /**
     * Cria um novo link.
     */
    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|url|max:2083'
        ]);

        $dados = $request->all();
        $link = Contact::create($dados);

        if (!$link) {
            return response()->json(['message' => 'Erro ao criar link', 'data' => null], 500);
        }
        return response()->json(['message' => 'Link criado', 'data' => $link], 201);
    }

    /**
     * Atualiza um link existente.
     */
    public function update($id, Request $request)
    {
        $dados = Contact::find($id);
        if (!$dados) {
            return response()->json(['message' => 'Link não encontrado', 'data' => null], 404);
        }

        $request->validate([
            'url' => 'url|max:2083'
        ]);

        $dados->update($request->all());
        return response()->json(['message' => 'Link atualizado', 'data' => $dados], 200);
    }

    /**
     * Remove um link do sistema.
     */
    public function destroy($id)
    {
        $dados = Contact::find($id);
        if (!$dados) {
            return response()->json(['message' => 'Link não encontrado', 'data' => null], 404);
        }

        $dados->delete();
        return response()->json(['message' => 'Link removido', 'data' => $dados], 200);
    }
}

