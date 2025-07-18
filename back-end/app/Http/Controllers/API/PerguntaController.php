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

        // Filtro por fase (?fase_id=3)
        if ($request->has('fase_id')) {
            $query->where('fase_id', $request->fase_id);
        }

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
        return response()->json($pergunta, 200);
    }

    /**
     * Criar uma nova pergunta, obrigando todos os campos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fase_id'        => 'required|exists:fases,id',
            'question'       => 'required|string|max:1000',
            'image'          => 'required|image|mimes:jpg,png,jpeg|max:2048',

            // Validando cada opção separadamente
            'option_a'       => 'required|string|max:255',
            'option_b'       => 'required|string|max:255',
            'option_c'       => 'required|string|max:255',
            'option_d'       => 'required|string|max:255',

            // Validando a resposta correta
            'correct_answer' => ['required', Rule::in(['A', 'B', 'C', 'D'])],

        ], [
            // Mensagens de erro personalizadas
            'fase_id.required'         => 'O campo fase é obrigatório.',
            'fase_id.exists'           => 'A fase informada não existe.',
            'question.required'        => 'O campo da pergunta é obrigatório.',

            'image.image'              => 'O arquivo deve ser uma imagem.',
            'image.mimes'              => 'A imagem deve ser do tipo: jpeg, png, jpg, ou svg.',

            'option_a.required'        => 'A opção A é obrigatória.',
            'option_b.required'        => 'A opção B é obrigatória.',
            'option_c.required'        => 'A opção C é obrigatória.',
            'option_d.required'        => 'A opção D é obrigatória.',

            'correct_answer.required'  => 'O campo da resposta correta é obrigatório.',
            'correct_answer.in'        => 'A resposta correta deve ser A, B, C ou D.',
        ]);

        // if ($request->hasFile('image')) {}
        $imagePath = $request->file('image')->store('image', 'public');
        $pergunta = Pergunta::create([
            'fase_id'        => $validated['fase_id'],
            'question'       => $validated['question'],
            'image'          => $imagePath,
            'correct_answer' => $validated['correct_answer'],
            'option_a'       => $validated['option_a'],
            'option_b'       => $validated['option_b'],
            'option_c'       => $validated['option_c'],
            'option_d'       => $validated['option_d'],
        ]);
        return response()->json($pergunta, 201);
    }

    /**
     * Atualizar pergunta, obrigando todos os campos.
     */
    public function update(Request $request, Pergunta $pergunta)
    {
        $validated = $request->validate([
            'fase_id'        => 'required|exists:fases,id',
            'question'       => 'required|string|max:1000',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',

            // Validando cada opção separadamente
            'option_a'       => 'required|string|max:255',
            'option_b'       => 'required|string|max:255',
            'option_c'       => 'required|string|max:255',
            'option_d'       => 'required|string|max:255',

            // Validando a resposta correta
            'correct_answer' => ['required', Rule::in(['A', 'B', 'C', 'D'])],

        ], [
            // Mensagens de erro personalizadas
            'fase_id.required'         => 'O campo fase é obrigatório.',
            'fase_id.exists'           => 'A fase informada não existe.',
            'question.required'        => 'O campo da pergunta é obrigatório.',

            'image.image'              => 'O arquivo deve ser uma imagem.',
            'image.mimes'              => 'A imagem deve ser do tipo: jpeg, png, jpg, ou svg.',

            'option_a.required'        => 'A opção A é obrigatória.',
            'option_b.required'        => 'A opção B é obrigatória.',
            'option_c.required'        => 'A opção C é obrigatória.',
            'option_d.required'        => 'A opção D é obrigatória.',

            'correct_answer.required'  => 'O campo da resposta correta é obrigatório.',
            'correct_answer.in'        => 'A resposta correta deve ser A, B, C ou D.',
        ]);

        if ($request->hasFile('image')) {
            // CORREÇÃO: Deleta a imagem antiga se ela existir
            if ($pergunta->image && Storage::disk('public')->exists($pergunta->image)) {
                Storage::disk('public')->delete($pergunta->image);
            }
            // Salva a nova imagem
            $file_path = $request->file('image')->store('image', 'public');
            $validatedData['image'] = $file_path;
        }

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
