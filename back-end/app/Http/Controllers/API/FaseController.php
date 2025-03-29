<?php

namespace App\Http\Controllers\API;

use App\Models\Fase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FaseController extends Controller
{
    public function index()
    {
        // Lista todas as fases, sem paginação.
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

    public function show(Fase $fase)
    {
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
