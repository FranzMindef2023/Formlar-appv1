<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuposCentrosReclutamiento extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'cupos_centros_reclutamientos';

    public function centro_reclutamiento()
    {
        return $this->belongsTo(CentrosReclutamiento::class, 'id_centros_reclutamiento', 'id');
    }
}
