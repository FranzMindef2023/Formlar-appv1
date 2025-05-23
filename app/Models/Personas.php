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
        'complemento_ci',
        'expedido',
        'celular',
        'correo',
        'fecha_nacimiento',
        'sexo',
        'direccion',
        'foto',
        'nacionalidad',
        'uuid',
        'creado_por',
        'ip_registro',
        'origen_registro',
        'gestion',
        'status'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'status' => 'boolean',
    ];
}
