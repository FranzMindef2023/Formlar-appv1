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
            ['division' => 'Division 1', 'codigo_departamento' => 1],
            ['division' => 'Division 2', 'codigo_departamento' => 2],
            ['division' => 'Division 3', 'codigo_departamento' => 3],
            ['division' => 'Division 4', 'codigo_departamento' => 4],
            ['division' => 'Division 5', 'codigo_departamento' => 5],
            ['division' => 'Division 6', 'codigo_departamento' => 6],
            ['division' => 'Division 7', 'codigo_departamento' => 9],
            ['division' => 'Division 8', 'codigo_departamento' => 8],
            ['division' => 'Division 9', 'codigo_departamento' => 7],
            ['division' => 'Division 10', 'codigo_departamento' => 7],
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
