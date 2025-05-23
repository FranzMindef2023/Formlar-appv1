<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\UnidadesMilitares;

class AsignacionesPresentacion extends Model
{
    protected $table = 'asignaciones_presentacion';
    protected $fillable = [
        'id_lugar_residencia',
        'unidad_militar_id',
        'id_centro_presentacion',
        'gestion',
        'fecha_presentacion',
        'hora_presentacion',
        'status'
    ];

    public function unidadMilitar()
    {
        return $this->belongsTo(UnidadesMilitares::class, 'unidad_militar_id');
    }

    public function centroPresentacion()
    {
        return $this->belongsTo(UnidadesMilitares::class, 'id_centro_presentacion');
    }
}
