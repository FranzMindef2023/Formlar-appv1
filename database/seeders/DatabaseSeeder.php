<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            FuerzasSeeder::class,
            DepartamentoSeeder::class,
            DivisionSeeder::class,
            CentrosReclutamientoSeeder::class,
            UserSeeder::class,
            AperturaSeeder::class,
        ]);
    }
}
