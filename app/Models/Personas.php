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
        'celular'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'status' => 'boolean',
    ];
}
