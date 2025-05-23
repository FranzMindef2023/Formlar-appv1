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
        'id_padre',
        'status',
        'id_fuerza',
        'provincia',
    ];
}
