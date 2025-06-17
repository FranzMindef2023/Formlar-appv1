<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class EstudianteInvitado extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $primaryKey = 'id';
    // Especificar el nombre de la tabla si no sigue la convención
    protected $table = 'estudiantes_invitados';

    // Desactivar timestamps si no usas created_at / updated_at
    public $timestamps = false;
    // Campos asignables masivamente
    protected $fillable = [
        'nro',
        'gestion',
        'departamento',
        'unidad_educativa',
        'codigo_unidad',
        'codigo_rude',
        'apellido_paterno',
        'apellido_materno',
        'nombres',
        'ci',
        'complemento',
        'expedido',
        'fecha_nacimiento',
        'sexo',
        'validado_por_segip',
        'distrito_educativo',
        'zona',
        'direccion',
        'nota_final',
        'edad_actual',
        'edad_al_05_10_202',
        'cumple_rango_edad',
        'invitado',
        'correlativo',
        'fecha_presentacion',
        'hora_presentacion',
        'descripcion',
        'fecha_registro',
    ];
}
