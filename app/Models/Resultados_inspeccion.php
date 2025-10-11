<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resultados_inspeccion extends Model
{
    protected $table = 'resultados_inspeccion';
    protected $primaryKey = 'id_resultado';

    protected $fillable = [
        'id_inspeccion',
        'id_actividad',
        'valor_respuesta',
        'observacion_item',
        'fecha'
    ];

    public $timestamps = false;
}
