<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inspecciones extends Model
{
    protected $table = 'inspecciones';
    protected $primaryKey = 'id_inspeccion';

    protected $fillable = [
        'id_user',
        'id_equipo',
        'fecha_inspeccion',
        'periodo_desde',
        'periodo_hasta',
        'observaciones',
        'firma_conductor',
        'firma_responsable_sst',
    ];
    public $timestamps = false;
}
