<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadesEducativa extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $primaryKey = 'codigo';
    protected $keyType = 'integer';
    public $incrementing = false;

    protected $table = 'unidades_educativas';

    public function cupos_unidades_educativa()
    {
        return $this->hasMany(CuposUnidadesEducativa::class, 'unidades_educativa_codigo', 'codigo');
    }
}
