<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pergunta extends Model
{
    use HasFactory;

    protected $fillable = [
        'fase_id',
        'question',
        'image',
        'correct_answer',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
    ];

    /**
     * Relacionamento com Fase (N:1)
     */
    public function fase()
    {
        return $this->belongsTo(Fase::class, 'fase_id');
    }
}
