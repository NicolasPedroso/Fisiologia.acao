<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'icon',
    ];

    /**
     * Um Tema tem muitas Fases.
     */
    public function fases(): HasMany
    {
        return $this->hasMany(Fase::class);
    }
}
