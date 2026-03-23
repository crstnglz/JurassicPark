<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dinosaurio extends Model
{
    protected $fillable = [
        'nick',
        'raza',
        'edad',
        'nivel_peligrosidad',
        'dieta',
        'celda_id',
        'estado'
    ];

    public function celda()
    {
        return $this->belongsTo(Celda::class);
    }
}
