<?php

namespace Database\Seeders;

use App\Models\CentrosReclutamiento;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CentrosReclutamientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        CentrosReclutamiento::truncate();
        $heading = true;
        $input_file = fopen(base_path("database/data/centros.csv"), "r");
        while (($record = fgetcsv($input_file, 1000, ",")) !== FALSE) {
            if (!$heading) {
                $centro = [
                    'regimiento' => $record[0],
                    'codigo' => $record[1],
                    'codigo_division' => $record[2],
                    'id_fuerza' => $record[3],
                    'prioridad' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                CentrosReclutamiento::create($centro);
            }
            $heading = false;
        }
        fclose($input_file);       //


    }
}
