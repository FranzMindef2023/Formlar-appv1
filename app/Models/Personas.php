<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Personas extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'nombres',
        'primer_apellido',
        'segundo_apellido',
        'ci',
        'fecha_nacimiento',
        'status',
        'id_departamento',
        'id_lugar_nacimiento',
        'id_centro_reclutamiento',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'status' => 'boolean',
    ];

    public function departamento()
    {
        return $this->belongsTo(UbicacionGeografica::class, 'id_departamento', 'idubigeo');
    }

    public function lugarNacimiento()
    {
        return $this->belongsTo(UbicacionGeografica::class, 'id_lugar_nacimiento', 'idubigeo');
    }

    public function centroReclutamiento()
    {
        return $this->belongsTo(UnidadEspecial::class, 'id_centro_reclutamiento');
    }
}
