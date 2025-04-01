<?php

namespace App\Http\Controllers\API;

use App\Models\Pergunta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PerguntaController extends Controller
{
    /**
     * Listar perguntas com filtros, mas SEM paginação.
     * Se não houver registro, retorna { "data": [] }.
     */
    public function index(Request $request)
    {
        $query = Pergunta::query();

        // Filtro por dificuldade (?dificuldade=2)
        if ($request->has('dificuldade')) {
            $query->where('dificuldade', $request->dificuldade);
        }

        // Filtro por fase (?fase_id=3)
        if ($request->has('fase_id')) {
            $query->where('fase_id', $request->fase_id);
        }

        // Se quiser carregar as respostas, descomente:
        $query->with('respostas');

        // Em vez de paginate, usamos get()
        $result = $query->get();

        // Se vazio, retornar { data: [] }
        if ($result->isEmpty()) {
            return response()->json(['data' => []], 200);
        }

        // Caso tenha registros, retornar { data: [...] }
        return response()->json(['data' => $result], 200);
    }

    /**
     * Exibir detalhes de uma pergunta (com respostas, se quiser).
     */
    public function show(Pergunta $pergunta)
    {
        // Carrega respostas (opcional)
        $pergunta->load('respostas');

        return response()->json($pergunta, 200);
    }

    /**
     * Criar uma nova pergunta, obrigando todos os campos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fase_id'      => 'required|exists:fases,id',
            'texto'        => 'required|string',
            'dificuldade'  => 'required|integer|in:1,2,3',
            'imagem'       => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            'video_link'   => 'required|string',
        ], [
            'fase_id.required' => 'Falta preencher o campo fase_id',
            'fase_id.exists'   => 'A fase informada não existe',
            'texto.required'   => 'Falta preencher o campo texto',
            'dificuldade.required' => 'Falta preencher o campo dificuldade',
            'dificuldade.in'   => 'Dificuldade deve ser 1, 2 ou 3',
            'imagem.required'  => 'Falta preencher o campo imagem',
            'video_link.required' => 'Falta preencher o campo video_link',
        ]);

        $pergunta = Pergunta::create($request->all());
        return response()->json($pergunta, 201);
    }

    /**
     * Atualizar pergunta, obrigando todos os campos.
     */
    public function update(Request $request, Pergunta $pergunta)
    {
        $request->validate([
            'fase_id'      => 'required|exists:fases,id',
            'texto'        => 'required|string',
            'dificuldade'  => 'required|integer|in:1,2,3',
            'imagem'       => 'required|string',
            'video_link'   => 'required|string',
        ], [
            'fase_id.required' => 'Falta preencher o campo fase_id',
            'fase_id.exists'   => 'A fase informada não existe',
            'texto.required'   => 'Falta preencher o campo texto',
            'dificuldade.required' => 'Falta preencher o campo dificuldade',
            'dificuldade.in'   => 'Dificuldade deve ser 1, 2 ou 3',
            'imagem.required'  => 'Falta preencher o campo imagem',
            'video_link.required' => 'Falta preencher o campo video_link',
        ]);

        $pergunta->update($request->all());
        return response()->json($pergunta, 200);
    }

    /**
     * Deletar pergunta.
     */
    public function destroy(Pergunta $pergunta)
    {
        $pergunta->delete();
        return response()->json(null, 204);
    }
}
