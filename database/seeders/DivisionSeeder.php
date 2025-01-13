<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $divisions = [
            ['division' => 'Region Militar 1', 'codigo_departamento' => 2], // la paz
            ['division' => 'Region Militar 2', 'codigo_departamento' => 4], // oruro
            ['division' => 'Region Militar 3', 'codigo_departamento' => 6], // tarija
            ['division' => 'Region Militar 4', 'codigo_departamento' => 1], // sucre
            ['division' => 'Region Militar 5', 'codigo_departamento' => 1], // solo para rellenar
            ['division' => 'Region Militar 6', 'codigo_departamento' => 8], // beni
            ['division' => 'Region Militar 7', 'codigo_departamento' => 3], // cochabamba
            ['division' => 'Region Militar 8', 'codigo_departamento' => 7], // santa cruz
            ['division' => 'Region Militar 9', 'codigo_departamento' => 9], // pando
            ['division' => 'Region Militar 10', 'codigo_departamento' => 5], // potosi
        ];
        foreach ($divisions as $division) {
            DB::table('divisions')->insert([
                'division' => $division['division'],
                'codigo_departamento' => $division['codigo_departamento'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
