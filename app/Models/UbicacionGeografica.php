<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UbicacionGeografica extends Model
{
    protected $table = 'ubicacion_geografica';
    protected $primaryKey = 'idubigeo';
    public $timestamps = false;

    protected $fillable = [
        'id_padre',
        'ubigeo',
        'codigoubigeo',
        'descubigeo',
        'nivel',
        'siglaubigeo',
        'id_zona_geografica',
    ];
}
