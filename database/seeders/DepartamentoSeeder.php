<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departamentos = [
            [
                'departamento' => 'La Paz',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'departamento' => 'Santa Cruz',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'departamento' => 'Potosi',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'departamento' => 'Chuquisaca',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'departamento' => 'Pando',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'departamento' => 'Beni',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'departamento' => 'Cochabamba',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'departamento' => 'Tarija',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'departamento' => 'Oruro',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('departamentos')->insert($departamentos);
    }
}
