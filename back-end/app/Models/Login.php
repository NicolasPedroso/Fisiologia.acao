<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;

/* Authenticatable para fornecer métodos de autenticação */
class Login extends Authenticatable
{
    use HasApiTokens, HasFactory; //Create_token -> HasApiTokens

    protected $table = 'login';
    protected $fillable = ["email", "password", "admin"];
}
