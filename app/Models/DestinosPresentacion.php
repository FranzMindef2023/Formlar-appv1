<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DestinosPresentacion extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $table = 'destinos_presentacion';
    protected $primaryKey = 'id';

    protected $fillable = [
        'gestion',
        'persona_id',
        'id_departamento_presenta',
        'id_centro_reclutamiento',
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
