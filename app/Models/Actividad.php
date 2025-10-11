<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table = 'actividades';

    protected $primaryKey = 'id_actividad';

    protected $fillable = [
        'name',
        'categoria_id',
        'fecha'
    ];

    public $timestamps = false;
}
