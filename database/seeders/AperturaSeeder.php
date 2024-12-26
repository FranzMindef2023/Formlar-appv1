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
            "gestion" =>  2024,
            "cantidad" =>  500,
            "fecha_limite" =>  "2024-12-31",
            "fecha_apertura" =>  "2024-01-01",
            "edad_min" =>  17,
            "edad_max" =>  19,
            "cite_junta" =>  "Ejemplo de texto para cite junta.",
            "firma_mae" =>  "Ejemplo de texto para firma MAE.",
            "created_at" => now(),
            "updated_at" => now()
        ];
        DB::table('aperturas')->insert($apertura);
    }
}
