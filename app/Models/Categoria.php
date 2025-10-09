<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class categoria extends Model
{
    // Nombre de la tabla
    protected $table = 'categoria';

    // Campos permitidos
    protected $fillable = [
        'nombre',
        'fecha'
    ];

    // Campos ocultos al convertir a JSON
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

}
