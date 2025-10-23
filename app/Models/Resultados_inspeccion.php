<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resultados_inspeccion extends Model
{
    protected $table = 'resultados_inspeccions';
    protected $primaryKey = 'id_resultado';

    protected $fillable = [
        'id_inspeccion',
        'id_actividad',
        'dia_semana',
        'turno',
        'valor_respuesta',
        'observacion_item',
        'fecha'
    ];

    public $timestamps = false;
}
