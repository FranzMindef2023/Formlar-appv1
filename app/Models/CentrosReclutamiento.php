<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentrosReclutamiento extends Model
{
    use HasFactory;

    protected $table = 'centros_reclutamientos';

    public function cupos_centros_reclutamientos_gestiones()
    {
        return $this->hasMany(CuposCentrosReclutamiento::class, 'id_centros_reclutamiento', 'id');
    }
    public function fuerza()
    {
        return $this->belongsTo(Fuerzas::class, 'id_fuerza', 'idfuerza');
    }
}
