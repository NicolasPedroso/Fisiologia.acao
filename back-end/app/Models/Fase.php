<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'numero',
        'descricao',
    ];

    /**
     * Relacionamento 1:N com Perguntas
     */
    public function perguntas()
    {
        // O 'fase_id' é a coluna que relaciona perg->fase
        return $this->hasMany(Pergunta::class, 'fase_id');
    }
}
