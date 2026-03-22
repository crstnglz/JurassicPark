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

    public function dinosaurios()
    {
        return $this->hasMany(Dinosaurio::class);
    }

    //una celda tiene muchas tareas
    public function tareas()
    {
        return $this->hasMany(Tarea::class);
    }
}
