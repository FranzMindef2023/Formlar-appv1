<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AperturaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apertura = [
            "gestion" =>  2025,
            "cantidad" =>  500,
            "fecha_limite" =>  "2025-08-31",
            "fecha_apertura" =>  date("Y-m-d"),
            "edad_min" =>  17,
            "edad_max" =>  21,
            "cite_junta" =>  "Ejemplo de texto para cite junta.",
            "firma_mae" =>  "Ejemplo de texto para firma MAE.",
            "created_at" => now(),
            "updated_at" => now()
        ];
        DB::table('aperturas')->insert($apertura);
    }
}
