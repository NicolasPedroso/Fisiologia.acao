<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Http\Response; // Usado para os códigos de status HTTP

class ThemeController extends Controller
{
    /**
     * Exibe uma lista paginada de temas.
     * Cada tema inclui a contagem de fases relacionadas.
     */
    public function index()
    {
        // Usar paginate é melhor para performance do que all()
        // withCount('fases') adiciona um campo 'fases_count' a cada tema
        $themes = Theme::withCount('fases')->latest()->paginate(15);

        return response()->json([
            'message' => 'sucesso',
            'data' => $themes
        ], Response::HTTP_OK); // 200
    }


    /**
     * Mostra um tema específico pelo seu ID, incluindo as fases.
     * Usa Route Model Binding: o Laravel encontra o tema ou retorna 404 automaticamente.
     */
    public function show(Theme $tema) // Note que mudei de $id para Theme $tema
    {
        // Carrega a relação com as fases para incluir na resposta
        $tema->load('fases');

        return response()->json([
            'message' => 'success',
            'data' => $tema
        ], Response::HTTP_OK); // 200
    }

    /**
     * Cria um novo tema.
     */
    public function store(Request $request)
    {
        // Validação dos dados de entrada
        $validatedData = $request->validate([
            'title' => 'required|string|max:255|unique:themes,title',
            'icone' => 'nullable|string|max:100',
        ]);

        $theme = Theme::create($validatedData);

        return response()->json([
            'message' => 'Tema criado',
            'data' => $theme
        ], Response::HTTP_CREATED); // 201
    }

    /**
     * Atualiza um tema existente.
     * Usa Route Model Binding.
     */
    public function update(Request $request, Theme $tema)
    {
        // Validação, garantindo que o título seja único, exceto para o próprio tema
        $validatedData = $request->validate([
            'title' => 'required|string|max:255|unique:themes,title,' . $tema->id,
            'icone' => 'nullable|string|max:100',
        ]);

        $tema->update($validatedData);

        return response()->json([
            'message' => 'Tema atualizado',
            'data' => $tema
        ], Response::HTTP_OK); // 200
    }

    /**
     * Remove um tema do sistema.
     * Usa Route Model Binding.
     */
    public function destroy(Theme $tema)
    {
        $tema->delete();

        // Retorna o tema que foi removido, seguindo o seu padrão
        return response()->json([
            'message' => 'Tema removido',
            'data' => $tema
        ], Response::HTTP_OK); // 200
    }
}
