<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileIconRequest;
use App\Models\ProfileIcon;
use Illuminate\Http\Request;

class ProfileIconController extends Controller
{
       /**
     * Exibe todos os ícones de perfil cadastrados.
     */
    public function index()
    {
        $icons = ProfileIcon::all();
        
        return response()->json([
            'message' => 'Sucesso ao buscar ícones de perfil',
            'data'    => $icons
        ], 200);
    }

    /**
     * Salva um novo ícone de perfil.
     */
    public function store(Request $request)
    {
        // Validação manual dos dados
        $request->validate([
            'image' => 'required|file|mimes:jpg,jpeg,bmp,png|max:2048'
        ]);
    
        if (!$request->hasFile('image')) {
            return response()->json([
                'message' => "Campo 'image' é obrigatório"
            ], 400);
        }
    
        // Salva a imagem na pasta public/profile_icons/
        $image = $request->file('image');
        $imageName = time().'_'.$image->getClientOriginalName();
        $image->move(public_path('profile_icons'), $imageName);
    
        // Cria um novo registro no banco de dados
        $icon = ProfileIcon::create([
            'image' => 'profile_icons/'.$imageName,
        ]);
    
        return response()->json([
            'message' => 'Ícone de perfil salvo com sucesso',
            'data'    => $icon
        ], 201);
    }
    

    /**
     * Exibe um ícone de perfil específico.
     */
    public function show(string $id)
    {
        $icon = ProfileIcon::find($id);
        
        if (!$icon) {
            return response()->json([
                'message' => 'Ícone de perfil não encontrado'
            ], 404);
        }

        return response()->json([
            'message' => 'Ícone de perfil encontrado com sucesso',
            'data'    => $icon
        ], 200);
    }

    /**
     * Atualiza um ícone de perfil existente.
     */
    public function update(Request $request, string $id)
    {
        $icon = ProfileIcon::find($id);
        
        if (!$icon) {
            return response()->json([
                'message' => 'Ícone de perfil não encontrado'
            ], 404);
        }
    
        // Validação manual dos dados
        $request->validate([
            'image' => 'nullable|file|mimes:jpg,jpeg,bmp,png|max:2048'
        ]);
    
        if ($request->hasFile('image')) {
            // Deleta a imagem antiga (se existir)
            $oldImagePath = public_path($icon->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
    
            // Salva a nova imagem
            $image = $request->file('image');
            $imageName = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('profile_icons'), $imageName);
    
            // Atualiza o caminho no banco
            $icon->image = 'profile_icons/'.$imageName;
        }
    
        $icon->save();
    
        return response()->json([
            'message' => 'Ícone de perfil atualizado com sucesso',
            'data'    => $icon
        ], 200);
    }
    

    /**
     * Remove um ícone de perfil.
     */
    public function destroy(string $id)
    {
        $icon = ProfileIcon::find($id);
        
        if (!$icon) {
            return response()->json([
                'message' => 'Ícone de perfil não encontrado'
            ], 404);
        }

        // Remove a imagem do servidor
        $imagePath = public_path($icon->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Remove do banco de dados
        $icon->delete();

        return response()->json([
            'message' => 'Ícone de perfil removido com sucesso'
        ], 200);
    }
}
