<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class categoria extends Model
{
    // Nombre de la tabla
    protected $table = 'categorias';

    // Campos permitidos
    protected $fillable = [
        'nombre',
        'fecha'
    ];

    // Le decimos a Laravel que NO gestione las columnas created_at y updated_at
    public $timestamps = false;

}
