<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\VideoTheme;
use App\Http\Requests\VideoThemeRequest;
use Illuminate\Http\Request;

class VideoThemeController extends Controller
{
    /**
     * Retorna a lista de todos os registros na tabela VideoTheme.
     */
    public function index()
    {
        $videoThemes = VideoTheme::all();
        return response()->json([
            'message' => 'sucesso',
            'data' => $videoThemes
        ], 200);
    }

    /**
     * Armazena um novo registro no banco de dados.
     */
    public function store(VideoThemeRequest $request)
    {
        $videoTheme = VideoTheme::create($request->validated());

        if (!$videoTheme) {
            return response()->json(['message' => 'Erro ao criar registro', 'data' => null], 500);
        }
        return response()->json(['message' => 'Registro criado com sucesso', 'data' => $videoTheme], 201);
    }

    /**
     * Retorna um registro específico pelo ID.
     */
    public function show($id)
    {
        $videoTheme = VideoTheme::find($id);
        if (!$videoTheme) {
            return response()->json(['message' => 'Registro não encontrado', 'data' => null], 404);
        }
        return response()->json(['message' => 'sucesso', 'data' => $videoTheme], 200);
    }

    /**
     * Atualiza um registro existente.
     */
    public function update($id, VideoThemeRequest $request)
    {
        $videoTheme = VideoTheme::find($id);
        if (!$videoTheme) {
            return response()->json(['message' => 'Registro não encontrado', 'data' => null], 404);
        }

        $videoTheme->update($request->validated());
        return response()->json(['message' => 'Registro atualizado com sucesso', 'data' => $videoTheme], 200);
    }

    /**
     * Remove um registro específico pelo ID.
     */
    public function destroy($id)
    {
        $videoTheme = VideoTheme::find($id);
        if (!$videoTheme) {
            return response()->json(['message' => 'Registro não encontrado', 'data' => null], 404);
        }
        
        $videoTheme->delete();
        return response()->json(['message' => 'Registro removido com sucesso', 'data' => $videoTheme], 200);
    }

    /**
     * Remove todos os registros da tabela VideoTheme.
     */
    public function destroyAll()
    {
        VideoTheme::truncate();
        return response()->json(['message' => 'Todos os registros foram deletados'], 200);
    }
}
