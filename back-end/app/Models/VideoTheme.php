<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoTheme extends Model
{
    use HasFactory;

    protected $fillable =['link','tema','identification'];
}

