<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fuerzas extends Model
{
    protected $table = 'fuerzas';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
    ];
}
