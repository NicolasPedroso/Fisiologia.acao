<?php

namespace App\Http\Controllers;

use App\Models\Resposta;
use App\Models\Pergunta;
use Illuminate\Http\Request;

class RespostaController extends Controller
{
    /**
     * Listar todas as respostas (pouco comum, mas existe no apiResource).
     */
    public function index()
    {
        return Resposta::all();
    }

    /**
     * Criar UMA resposta (padrão apiResource).
     */
    public function store(Request $request)
    {
        $request->validate([
            'pergunta_id' => 'required|exists:perguntas,id',
            'texto'       => 'required|string',
            'correta'     => 'required|boolean',
        ]);

        // Se for "correta = true", checar se já existe outra resposta correta
        if ($request->correta) {
            $existeCorreta = Resposta::where('pergunta_id', $request->pergunta_id)
                                     ->where('correta', true)
                                     ->exists();

            if ($existeCorreta) {
                return response()->json([
                    'message' => 'Já existe uma resposta correta para esta pergunta.'
                ], 422);
            }
        }

        $resposta = Resposta::create($request->all());

        return response()->json($resposta, 201);
    }

    /**
     * Exibir UMA resposta (padrão apiResource).
     */
    public function show(Resposta $resposta)
    {
        return response()->json($resposta, 200);
    }

    /**
     * Atualizar UMA resposta (padrão apiResource).
     */
    public function update(Request $request, Resposta $resposta)
    {
        $request->validate([
            'pergunta_id' => 'required|exists:perguntas,id',
            'texto'       => 'required|string',
            'correta'     => 'required|boolean',
        ]);

        // Se estamos mudando de false para true, verificar se já existe outra correta
        if ($request->correta && !$resposta->correta) {
            $existeCorreta = Resposta::where('pergunta_id', $request->pergunta_id)
                                     ->where('correta', true)
                                     ->where('id', '!=', $resposta->id)
                                     ->exists();

            if ($existeCorreta) {
                return response()->json([
                    'message' => 'Já existe uma resposta correta para esta pergunta.'
                ], 422);
            }
        }

        $resposta->update($request->all());

        return response()->json($resposta, 200);
    }

    /**
     * Deletar UMA resposta (padrão apiResource).
     */
    public function destroy(Resposta $resposta)
    {
        $resposta->delete();

        return response()->json(null, 204);
    }

    /**
     * Criar VÁRIAS respostas de uma só vez (bulk),
     * vinculado a uma pergunta específica (via URL).
     *
     * Exemplo de body (JSON) esperado:
     * {
     *   "respostas": [
     *     { "texto": "Alternativa A", "correta": false },
     *     { "texto": "Alternativa B", "correta": true },
     *     ...
     *   ]
     * }
     */
    public function storeBulk(Request $request, Pergunta $pergunta)
    {
        $data = $request->validate([
            'respostas'             => 'required|array|min:1',
            'respostas.*.texto'     => 'required|string',
            'respostas.*.correta'   => 'required|boolean',
        ]);

        $inseridas = [];

        foreach ($data['respostas'] as $resp) {
            // Se estiver marcando como correta, verificar se já existe outra
            if ($resp['correta']) {
                $existeCorreta = Resposta::where('pergunta_id', $pergunta->id)
                                         ->where('correta', true)
                                         ->exists();
                if ($existeCorreta) {
                    return response()->json([
                        'message' => 'Já existe uma resposta correta para esta pergunta.'
                    ], 422);
                }
            }

            // Criar a resposta
            $nova = Resposta::create([
                'pergunta_id' => $pergunta->id,
                'texto'       => $resp['texto'],
                'correta'     => $resp['correta'],
            ]);

            $inseridas[] = $nova;
        }

        return response()->json([
            'message'   => 'Respostas inseridas com sucesso.',
            'respostas' => $inseridas
        ], 201);
    }
}
