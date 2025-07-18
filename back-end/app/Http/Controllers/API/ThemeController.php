<?php

namespace App\Http\Controllers\API;

use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule; // Importante para a validação no update

class ThemeController extends Controller
{
    /**
     * Retorna uma lista de todos os temas.
     * Cada tema inclui a contagem de fases relacionadas.
     */
    public function index(): JsonResponse
    {
        $themes = Theme::withCount('fases')->latest()->get();

        // Resposta padronizada
        return response()->json([
            'message' => 'Temas listados com sucesso',
            'data' => $themes
        ], Response::HTTP_OK);
    }

    /**
     * Cria um novo tema no banco de dados.
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255|unique:themes,title',
            'icon' => 'nullable|string|max:100', // Mudei para nullable para ser mais flexível
        ]);

        $theme = Theme::create($validatedData);

        // Resposta padronizada
        return response()->json([
            'message' => 'Tema criado com sucesso',
            'data' => $theme
        ], Response::HTTP_CREATED);
    }

    /**
     * Retorna um tema específico com suas fases relacionadas.
     * A lógica aqui está correta. Se os campos não aparecem,
     * verifique se você não está usando uma classe API Resource (ex: ThemeResource)
     * ou um Global Scope no Model Theme que esteja escondendo os campos.
     */
    public function show(Theme $theme): JsonResponse
    {
        // Carrega a relação com as fases para incluir na resposta
        $theme->load('fases');

        // Resposta padronizada
        return response()->json([
            'message' => 'Tema encontrado com sucesso',
            'data' => $theme
        ], Response::HTTP_OK);
    }

    /**
     * Atualiza um tema existente.
     */
    public function update(Request $request, Theme $theme): JsonResponse
    {
        $validatedData = $request->validate([
            // CORREÇÃO: Garante que o título seja único, ignorando o próprio tema atual.
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('themes')->ignore($theme->id),
            ],
            'icon' => 'nullable|string|max:100',
        ]);

        $theme->update($validatedData);

        // Resposta padronizada
        return response()->json([
            'message' => 'Tema atualizado com sucesso',
            'data' => $theme
        ], Response::HTTP_OK);
    }

    /**
     * Exclui um tema.
     */
    public function destroy(Theme $theme): JsonResponse
    {
        $theme->delete();

        // Retorna uma resposta com mensagem, em vez de vazia, para consistência.
        return response()->json([
            'message' => 'Tema excluído com sucesso',
            'data' => null
        ], Response::HTTP_OK);
    }
}
