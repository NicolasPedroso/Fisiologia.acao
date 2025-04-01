<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileIconRequest;
use App\Models\ProfileIcon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class ProfileIconController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(ProfileIconRequest $request): JsonResponse
    {
        if (!$request->hasFile('image')) {
            return response()->json(['message' => 'Campo Image é obrigatório'], 400);
        }

        $image_path = $request->file('image')->store('public/profile_icons');

        $profileIcon = ProfileIcon::create([
            'name' => $request->name,
            'image' => $image_path
        ]);

        return response()->json([
            'message' => 'Ícone de perfil cadastrado com sucesso!',
            'data' => $profileIcon
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProfileIcon $profileIcon): JsonResponse
    {
        return response()->json($profileIcon);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileIconRequest $request, ProfileIcon $profileIcon): JsonResponse
    {
        if ($request->hasFile('image')) {
            if ($profileIcon->image) {
                Storage::delete($profileIcon->image);
            }
            $profileIcon->image = $request->file('image')->store('public/profile_icons');
        }

        $profileIcon->name = $request->input('name');
        $profileIcon->save();

        return response()->json([
            'message' => 'Ícone de perfil atualizado com sucesso!',
            'data' => $profileIcon
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProfileIcon $profileIcon): JsonResponse
    {
        if ($profileIcon->image) {
            Storage::delete($profileIcon->image);
        }

        $profileIcon->delete();

        return response()->json(['message' => 'Ícone de perfil excluído com sucesso'], 200);
    }
}
