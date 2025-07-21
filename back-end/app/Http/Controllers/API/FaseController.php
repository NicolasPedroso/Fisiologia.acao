<?php

namespace App\Http\Controllers\API;

use App\Models\Fase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Models\Pergunta;

class FaseController extends Controller
{
    /**
     * Lista todas as fases.
     */
    public function index()
    {
        $user = Auth::user();

        $fases = Fase::withCount('perguntas')
            // ADICIONAL: Carrega os dados do tema junto com a fase
            ->with('theme')
            ->with(['users' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->get();

        return response()->json($fases);
    }

    /**
     * Cria uma nova fase e suas perguntas.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // 1. ADICIONAR VALIDAÇÃO PARA O THEME_ID
            'theme_id'    => 'required|integer|exists:themes,id', // Garante que o tema exista

            // Regras para a Fase
            'title'       => 'required|string|max:255',
            'image'       => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'video_link'  => 'required|url',
            'dificulty'   => ['required', Rule::in(['Fácil', 'Médio', 'Difícil'])],
            'description' => 'required|string',

            // Regras para o array de Perguntas
            'perguntas'              => 'required|array|min:1',
            'perguntas.*.question'   => 'required|string',
            'perguntas.*.image'      => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'perguntas.*.option_a'   => 'required|string',
            'perguntas.*.option_b'   => 'required|string',
            'perguntas.*.option_c'   => 'required|string',
            'perguntas.*.option_d'   => 'required|string',
            'perguntas.*.correct_answer' => ['required', Rule::in(['A', 'B', 'C', 'D'])],
        ]);

        $fase = null;

        try {
            DB::transaction(function () use ($request, $validatedData, &$fase) {
                $imagePath = $request->file('image')->store('image', 'public');

                // 2. INCLUIR O THEME_ID NA CRIAÇÃO
                $fase = Fase::create([
                    'theme_id'    => $validatedData['theme_id'], // <-- AQUI
                    'title'       => $validatedData['title'],
                    'image'       => $imagePath,
                    'video_link'  => $validatedData['video_link'],
                    'dificulty'   => $validatedData['dificulty'],
                    'description' => $validatedData['description'],
                ]);

                foreach ($validatedData['perguntas'] as $key => $perguntaData) {
                    if ($request->hasFile("perguntas.{$key}.image")) {
                        $perguntaImagePath = $request->file("perguntas.{$key}.image")->store('image', 'public');
                        $perguntaData['image'] = $perguntaImagePath;
                    }
                    $fase->perguntas()->create($perguntaData);
                }
            });
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocorreu um erro ao criar a fase e suas perguntas.',
                'error' => $e->getMessage()
            ], 500);
        }

        $fase->load('perguntas', 'theme'); // Carrega o tema recém-criado também
        return response()->json($fase, 201);
    }

    /**
     * Mostra uma fase específica.
     */
    public function show(Fase $fase)
    {
        $user = Auth::user();

        // Carrega todas as relações necessárias de uma vez
        $fase->load([
            'theme', // Carrega o tema pai
            'perguntas',
            'users' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }
        ]);

        return response()->json($fase, 200);
    }

    /**
     * Atualiza uma fase existente.
     */
    public function update(Request $request, Fase $fase)
    {
        $validatedData = $request->validate([
            // 3. ADICIONAL: Validação para mudar o tema de uma fase (opcional)
            'theme_id'    => 'sometimes|required|integer|exists:themes,id',

            'title'       => 'required|string|max:255',
            'image'       => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'video_link'  => 'required|url',
            'dificulty'   => ['required', Rule::in(['Fácil', 'Médio', 'Difícil'])],
            'description' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            if ($fase->image && Storage::disk('public')->exists($fase->image)) {
                Storage::disk('public')->delete($fase->image);
            }
            $file_path = $request->file('image')->store('image', 'public');
            $validatedData['image'] = $file_path;
        }

        $fase->update($validatedData);
        return response()->json($fase, 200);
    }

    // ... destroy e updateUserStatus permanecem os mesmos ...

    public function destroy(Fase $fase)
    {
        if ($fase->image && Storage::disk('public')->exists($fase->image)) {
            Storage::disk('public')->delete($fase->image);
        }

        $fase->delete();
        return response()->json(null, 204);
    }

    public function updateUserStatus(Request $request, Fase $fase)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['Completo', 'Não iniciado'])],
        ]);

        $user = Auth::user();

        $user->fases()->syncWithoutDetaching([
            $fase->id => ['status' => $validated['status']]
        ]);

        return response()->json(['message' => 'Status atualizado com sucesso.']);
    }
}
