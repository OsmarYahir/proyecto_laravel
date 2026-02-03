<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    use HasFactory;

    protected $table = 'imagenes'; // Especificamos el nombre de la tabla

    protected $fillable = [
        'titulo',
        'ruta',
        'nombre_original',
        'orden',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];
}