<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios'; // Nombre de la tabla en Render

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'telefono',
    ];
}