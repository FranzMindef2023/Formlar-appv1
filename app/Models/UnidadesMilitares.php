<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnidadesMilitares extends Model
{
    protected $table = 'unidades_militares';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'codigo',
        'descripcion',
        'id_ubicacion',
        'id_provincia',
        'id_padre',
        'id_fuerza',
        'es_centro_reclutamiento',
        'fecha_presentacion',
        'hora_presentacion',
        'status',
        'id_centro_reclutamiento',
    ];
    public function ubicacion()
    {
        return $this->belongsTo(UbicacionGeografica::class, 'id_ubicacion', 'idubigeo');
    }

    public function provincia()
    {
        return $this->belongsTo(UbicacionGeografica::class, 'id_provincia', 'idubigeo');
    }

    public function centroReclutamiento()
    {
        return $this->belongsTo(UnidadesMilitares::class, 'id_centro_reclutamiento');
    }
}
