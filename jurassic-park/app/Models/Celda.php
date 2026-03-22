<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Celda extends Model
{
    protected $fillable = [
        'nombre',
        'cantidad_animales',
        'nivel_peligrosidad',
        'alimento',
        'averias_pendientes',
        'nivel_seguridad'
    ];
}
