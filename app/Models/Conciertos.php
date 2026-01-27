<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conciertos extends Model
{
   protected $table = 'conciertos';
   

    protected $fillable = [
        'nombre',
        'fecha',
        'lugares',
        '',
    ];
   
}
