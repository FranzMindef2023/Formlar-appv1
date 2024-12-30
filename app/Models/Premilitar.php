<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Premilitar extends Model
{
    use HasFactory;

    protected $table = 'premilitars';
    protected $guarded = [];

    protected $dates = [
        'fecha_nacimiento',
        'fecha_presentacion',
        'fecha_registro'
    ];
}
