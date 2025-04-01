<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\NotificationIcon;
use App\Http\Requests\NotificationIconRequest;
use Illuminate\Http\Request;

class NotificationIconController extends Controller
{
    /**
     * Retorna o status atual da notificação.
     */
    public function index()
    {
        $notification = NotificationIcon::first();
        $status = $notification ? (bool) $notification->notification : false;
    
        return response()->json([
            'message' => 'Status da notificação recuperado com sucesso',
            'status' => $status
        ], 200);
    }

    /**
     * Cria ou atualiza o status da notificação.
     */
    public function store(NotificationIconRequest $request)
    {
        $notification = NotificationIcon::updateOrCreate(
            [],
            ['notification' => (bool) $request->notification]
        );
    
        return response()->json([
            'message' => 'Status da notificação salvo com sucesso',
            'status' => (bool) $notification->notification
        ], 200);
    }

    /**
     * Exibe o status específico da notificação.
     */
    public function show(NotificationIcon $notificationIcon)
    {
        return response()->json([
            'message' => 'Status da notificação recuperado com sucesso',
            'status' => (bool) $notificationIcon->notification
        ], 200);
    }

    /**
     * Atualiza o status da notificação.
     */
    public function update(NotificationIconRequest $request)
    {
        $notification = NotificationIcon::first();
    
        if (!$notification) {
            return response()->json([
                'message' => 'Registro de notificação não encontrado'
            ], 404);
        }
    
        $notification->update(['notification' => (bool) $request->notification]);
    
        return response()->json([
            'message' => 'Status da notificação atualizado com sucesso',
            'status' => (bool) $notification->notification
        ], 200);
    }
    
    /**
     * Remove o status da notificação.
     */
    public function destroy()
    {
        $notification = NotificationIcon::first();
    
        if (!$notification) {
            return response()->json([
                'message' => 'Nenhuma notificação encontrada'
            ], 404);
        }
    
        $notification->delete();
    
        return response()->json([
            'message' => 'Notificação removida com sucesso'
        ], 200);
    }
}
