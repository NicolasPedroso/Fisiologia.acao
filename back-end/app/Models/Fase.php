<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Support\Facades\Auth;

class Fase extends Model
{
    use HasFactory;

    /**
     * Se não quiser sobrescrever o nome da tabela:
     * protected $table = 'fases';
     */

    /**
     * Quais atributos podem ser atribuídos em massa.
     */
    protected $fillable = [
        'title',
        'image',
        'video_link',
        'dificulty',
        'description'
    ];

    protected $hidden = [
        'users'
    ];

    protected $appends = [
        'user_status'
    ];

    /**
     * Relacionamento 1:N com Perguntas
     */
    public function perguntas()
    {
        // O 'fase_id' é a coluna que relaciona perg->fase
        return $this->hasMany(Pergunta::class, 'fase_id');
    }

    public function users()
{
        // Precisamos informar o Laravel sobre a coluna extra 'status' na tabela pivot.
        return $this->belongsToMany(User::class, 'fase_user')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    /**
     * Um Accessor para obter o status DO USUÁRIO LOGADO de forma fácil.
     * Isso cria o atributo virtual 'user_status'.
     */
    public function getUserStatusAttribute()
    {
        if (!Auth::check()) {
            return 'Não iniciado';
        }

        // A relação 'users' ainda é carregada pelo controller, mas agora fica oculta.
        $userPivot = $this->users->first();

        return $userPivot ? $userPivot->pivot->status : 'Não iniciado';
    }
}
