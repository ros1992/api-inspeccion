<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class categorias extends Model
{
    // Nombre de la tabla
    protected $table = 'categorias';

    // Campos permitidos
    protected $fillable = [
        'id',
        'nombre',
        'fecha'
    ];

    // Campos ocultos al convertir a JSON
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

}
