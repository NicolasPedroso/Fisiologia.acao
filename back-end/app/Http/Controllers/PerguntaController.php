<?php

namespace App\Http\Controllers;

use App\Models\Pergunta;
use Illuminate\Http\Request;

class PerguntaController extends Controller
{
    public function index(Request $request)
    {
        // Iniciamos a query base
        $query = Pergunta::query();

        // Filtro por dificuldade (ex.: ?dificuldade=2)
        if ($request->has('dificuldade')) {
            $query->where('dificuldade', $request->dificuldade);
        }

        // Filtro por fase (ex.: ?fase_id=3)
        if ($request->has('fase_id')) {
            $query->where('fase_id', $request->fase_id);
        }

        // Carregar respostas (opcional)
        // Se quiser listar todas as perguntas já com as respostas,
        // descomente a linha abaixo:
        $query->with('respostas');

        // Paginar 10 por página
        return $query->paginate(10);
    }


    public function show(Pergunta $pergunta)
    {
        // Carrega respostas (opcional) antes de retornar
        $pergunta->load('respostas');

        return response()->json($pergunta, 200);
    }

    public function store(Request $request)
    {
        // Valida
        $request->validate([
            'fase_id' => 'nullable|exists:fases,id',  // Fase opcional, mas se informado, deve existir
            'texto' => 'required|string',
            'dificuldade' => 'required|integer|in:1,2,3',
            'imagem' => 'nullable|string',
            'video_link' => 'nullable|string',
        ]);

        // Cria a Pergunta
        $pergunta = Pergunta::create($request->all());

        return response()->json($pergunta, 201);
    }

    public function update(Request $request, Pergunta $pergunta)
    {
        $request->validate([
            'fase_id' => 'nullable|exists:fases,id',
            'texto' => 'required|string',
            'dificuldade' => 'required|integer|in:1,2,3',
            'imagem' => 'nullable|string',
            'video_link' => 'nullable|string',
        ]);

        $pergunta->update($request->all());

        return response()->json($pergunta, 200);
    }

    public function destroy(Pergunta $pergunta)
    {
        $pergunta->delete();
        return response()->json(null, 204);
    }
}
