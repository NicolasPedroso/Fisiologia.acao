<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pergunta extends Model
{
    use HasFactory;

    protected $fillable = [
        'fase_id',
        'texto',
        'dificuldade',
        'imagem',
        'video_link',
    ];

    /**
     * Relacionamento com Fase (N:1)
     */
    public function fase()
    {
        return $this->belongsTo(Fase::class, 'fase_id');
    }

    /**
     * Relacionamento com Respostas (1:N)
     */
    public function respostas()
    {
        return $this->hasMany(Resposta::class, 'pergunta_id');
    }
}
