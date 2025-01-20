<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function cupos_divisiones()
    {
        return $this->hasMany(CuposDivision::class, 'codigo_division', 'codigo');
    }
}
