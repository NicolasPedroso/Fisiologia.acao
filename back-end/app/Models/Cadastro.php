<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*Modelo do usuário conforme CRUD - Cadastro de usuário */
class Cadastro extends Model
{
    protected $table = 'cadastro';
    protected $fillable = ["nome", "email", "senha", "endereço", "telefone"];   
}
