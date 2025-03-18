<?php

namespace App\Http\Controllers;

use App\Models\Fase;
use Illuminate\Http\Request;

class FaseController extends Controller
{
    public function index()
    {
        return response()->json(Fase::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero'    => 'required|integer|unique:fases,numero',
            'descricao' => 'nullable|string',
        ]);

        $fase = Fase::create($request->all());

        return response()->json($fase, 201);
    }

    // Note aqui que a assinatura recebe Fase $fase
    public function show(Fase $fase)
    {
        // $fase já está carregado, ou 404 se não achar
        return response()->json($fase, 200);
    }

    public function update(Request $request, Fase $fase)
    {
        $request->validate([
            'numero'    => 'required|integer|unique:fases,numero,'.$fase->id,
            'descricao' => 'nullable|string',
        ]);

        $fase->update($request->all());

        return response()->json($fase, 200);
    }

    public function destroy(Fase $fase)
    {
        $fase->delete();

        return response()->json(null, 204);
    }
}
