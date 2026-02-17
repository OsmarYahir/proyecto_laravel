<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concierto extends Model
{
    use HasFactory;

    protected $table = 'conciertos';

    protected $fillable = [
        'nombre',
        'artista',
        'descripcion',
        'ubicacion',
        'fecha_evento',
        'precio',
        'capacidad_total',
        'boletos_disponibles',
        'status',
        'imagen_url'
    ];

    protected $casts = [
        'fecha_evento' => 'datetime',
        'precio' => 'decimal:2',
    ];

    /**
     * Verificar si hay boletos disponibles
     */
    public function tieneBoletos()
    {
        return $this->boletos_disponibles > 0;
    }

    /**
     * Reducir boletos disponibles
     */
    public function reducirBoletos($cantidad)
    {
        if ($this->boletos_disponibles >= $cantidad) {
            $this->boletos_disponibles -= $cantidad;
            $this->save();
            return true;
        }
        return false;
    }

    /**
     * Scope para conciertos activos
     */
    public function scopeActivos($query)
    {
        return $query->where('status', 'activo');
    }

    /**
     * Scope para conciertos próximos
     */
    public function scopeProximos($query)
    {
        return $query->where('fecha_evento', '>', now());
    }
}