<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    protected $fillable = [
        'user_id',
        'celda_id',
        'tipo',
        'estado',
        'descripcion'
    ];

    //una tarea pertenece a un user
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    //una tarea pertenece a una celda
    public function celda()
    {
        return $this->belongsTo(Celda::class, 'celda_id');
    }
}
