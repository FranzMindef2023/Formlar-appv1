<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuposUnidadesEducativa extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'cupos_unidades_educativas';


    public function unidades_educativas()
    {
        return $this->belongsTo(UnidadesEducativa::class, 'unidades_educativa_codigo', 'codigo');
    }

    public function centros_reclutamiento()
    {
        return $this->belongsTo(CentrosReclutamiento::class, 'centros_reclutamiento_id', 'id');
    }
}
