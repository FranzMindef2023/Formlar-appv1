<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZonasGeograficasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('zonas_geograficas')->insert([
            ['nombre' => 'ZONA OCCIDENTE', 'descripcion' => 'Región andina elevada, clima frío y seco.'],
            ['nombre' => 'ZONA VALLES', 'descripcion' => 'Región intermedia con clima templado y tierras fértiles.'],
            ['nombre' => 'ZONA ORIENTE', 'descripcion' => 'Región de tierras bajas tropicales y húmedas.'],
            ]);
    }
}
