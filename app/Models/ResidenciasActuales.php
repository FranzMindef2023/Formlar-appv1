<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ResidenciasActuales extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $table = 'residencias_actuales';
    protected $primaryKey = 'id';

    protected $fillable = [
        'gestion',
        'persona_id',
        'id_departamento',
        'id_lugar_recidencia',
        'status'
    ];

    // Relaciones
    public function persona()
    {
        return $this->belongsTo(Personas::class);
    }
    // ✅ Aquí va el scope
    public function scopeGestionActual($query)
    {
        return $query->where('gestion', date('Y'));
    }
}
