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
     * Lista todas as fases, incluindo o status do usuário logado em cada uma.
     */
    public function index()
    {
        $user = Auth::user();

        $fases = Fase::withCount('perguntas')
            // Pré-carrega a relação 'users', mas APENAS para o ID do usuário logado.
            // Isso é uma otimização crucial para evitar carregar dados de todos os usuários.
            ->with(['users' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->get();

        return response()->json($fases);
    }

    // ... store e update NÃO precisam mais validar o 'status'

public function store(Request $request)
    {
        // 2. ATUALIZAR A VALIDAÇÃO
        $validatedData = $request->validate([
            // Regras para a Fase
            'title'       => 'required|string|max:255',
            'image'       => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'video_link'  => 'required|url',
            'dificulty'   => ['required', Rule::in(['Fácil', 'Médio', 'Difícil'])],
            'description' => 'required|string',

            // Regras para o array de Perguntas (que virão no corpo da requisição)
            'perguntas'          => 'required|array|min:1',
            'perguntas.*.question'     => 'required|string',
            'perguntas.*.image'        => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'perguntas.*.option_a'     => 'required|string',
            'perguntas.*.option_b'     => 'required|string',
            'perguntas.*.option_c'     => 'required|string',
            'perguntas.*.option_d'     => 'required|string',
            'perguntas.*.correct_answer' => ['required', Rule::in(['A', 'B', 'C', 'D'])],
        ]);

        $fase = null;

        // 3. ENVOLVER TUDO EM UMA TRANSAÇÃO
        try {
            DB::transaction(function () use ($request, $validatedData, &$fase) {
                // Primeiro, cuida do upload da imagem da Fase
                $imagePath = $request->file('image')->store('image', 'public');

                // Segundo, cria a Fase no banco de dados
                $fase = Fase::create([
                    'title'       => $validatedData['title'],
                    'image'       => $imagePath, // Salva o caminho da imagem
                    'video_link'  => $validatedData['video_link'],
                    'dificulty'   => $validatedData['dificulty'],
                    'description' => $validatedData['description'],
                ]);

                // Itera sobre o array de perguntas para processá-las
                foreach ($validatedData['perguntas'] as $key => $perguntaData) {

                    // === AQUI ESTÁ A LÓGICA CORRIGIDA ===
                    // Verifica se existe um arquivo de imagem para esta pergunta específica
                    if ($request->hasFile("perguntas.{$key}.image")) {
                        // Salva a imagem da pergunta
                        $perguntaImagePath = $request->file("perguntas.{$key}.image")->store('image', 'public');
                        // Adiciona o caminho da imagem aos dados da pergunta antes de salvar
                        $perguntaData['image'] = $perguntaImagePath;
                    }

                    // Cria a pergunta usando os dados (que agora podem conter o caminho da imagem)
                    $fase->perguntas()->create($perguntaData);
                }
            });
        } catch (\Exception $e) {
            // Se algo der errado, a transação é revertida e nada é salvo.
            return response()->json([
                'message' => 'Ocorreu um erro ao criar a fase e suas perguntas.',
                'error' => $e->getMessage() // Útil para depuração
            ], 500);
        }

        // 4. RETORNAR A FASE COMPLETA COM AS PERGUNTAS
        $fase->load('perguntas');

        return response()->json($fase, 201);
    }

    public function show(Fase $fase)
    {
        $user = Auth::user();

        $fase->loadCount('perguntas')
            // Carrega o status apenas para o usuário logado
            ->load(['users' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }]);

        $fase->load([
            'perguntas', // <<--- AQUI ESTÁ A MUDANÇA PRINCIPAL
            'users' => function ($query) use ($user) {
                // Filtra o status para o usuário logado
                $query->where('user_id', $user->id);
            }
        ]);

        return response()->json($fase, 200);
    }

    public function update(Request $request, Fase $fase)
    {
        $validatedData = $request->validate([
            'title'       => 'required|string|max:255',
            'image'       => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'video_link'  => 'required|url',
            'dificulty'   => ['required', Rule::in(['Fácil', 'Médio', 'Difícil'])],
            'description' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            // CORREÇÃO: Deleta a imagem antiga se ela existir
            if ($fase->image && Storage::disk('public')->exists($fase->image)) {
                Storage::disk('public')->delete($fase->image);
            }
            // Salva a nova imagem
            $file_path = $request->file('image')->store('image', 'public');
            $validatedData['image'] = $file_path;
        }

        $fase->update($validatedData);
        return response()->json($fase, 200);
    }

    public function destroy(Fase $fase)
    {
        if ($fase->image && Storage::disk('public')->exists($fase->image)) {
            Storage::disk('public')->delete($fase->image);
        }

        $fase->delete();
        return response()->json(null, 204);
    }

    /**
     * Novo método para atualizar o status de uma fase para o usuário logado.
     */
    public function updateUserStatus(Request $request, Fase $fase)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['Completo', 'Não iniciado'])],
        ]);

        $user = Auth::user();

        // O método syncWithoutDetaching é perfeito aqui:
        // Ele cria a relação se não existir, ou atualiza se já existir.
        $user->fases()->syncWithoutDetaching([
            $fase->id => ['status' => $validated['status']]
        ]);

        return response()->json(['message' => 'Status atualizado com sucesso.']);
    }
}
