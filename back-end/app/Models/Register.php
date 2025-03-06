<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Register extends Models
{
    use HasApiTokens, HasFactory;
    protected $table = 'register';
    protected $fillable = ["name", "email", "password", "address", "phone"];
}
