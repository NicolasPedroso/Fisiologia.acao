<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\NotificationIcon;
use App\Http\Requests\NotificationIconRequest;
use Illuminate\Http\Request;

class NotificationIconController extends Controller
{
/**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notificationIcon = NotificationIcon::first();
    
        return response()->json([
            'message' => 'Status da notificação recuperado com sucesso',
            'data' => $notificationIcon
        ], 200);
    }    

    /**
     * Store a newly created resource in storage.
     */
    public function store(NotificationIconRequest $request)
    {
        $notificationIcon = NotificationIcon::updateOrCreate(
            [], // Garantindo que só exista um registro
            ['notification' => $request->notification]
        );

        return response()->json([
            'message' => 'Status da notificação atualizado com sucesso',
            'data' => $notificationIcon
        ], 200);
    }


    /**
     * Display the specified resource.
     */
    public function show(NotificationIcon $notificationIcon)
    {
        return response()->json([
            'message' => 'Status da notificação recuperado com sucesso',
            'data' => $notificationIcon
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NotificationIconRequest $request)
    {
        $notificationIcon = NotificationIcon::first();
        
        if (!$notificationIcon) {
            return response()->json([
                'message' => 'Registro de notificação não encontrado'
            ], 404);
        }
    
        $notificationIcon->update(['notification' => $request->notification]);
    
        return response()->json([
            'message' => 'Status da notificacao atualizado com sucesso',
            'data' => $notificationIcon
        ], 200);
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        $notificationIcon = NotificationIcon::first();
    
        if (!$notificationIcon) {
            return response()->json([
                'message' => 'Nenhuma notificação encontrada'
            ], 404);
        }
    
        $notificationIcon->delete();
    
        return response()->json([
            'message' => 'Notificação removida com sucesso'
        ], 200);
    }
    
}
