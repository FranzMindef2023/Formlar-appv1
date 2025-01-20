<?php

namespace Database\Seeders;

use App\Models\Estudiante;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class EstudiantesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Estudiante::truncate();
        $heading = true;
        $input_file = fopen(base_path("database/data/estudiantes.csv"), "r");
        while (($record = fgetcsv($input_file, 1000, ",")) !== FALSE) {
            if (!$heading) {
                $estudiante = [
                    "correlativo" => $record[0],
                    "departamento" => $record[1],
                    "unidad_educativa" => $record[2],
                    "codigo" => $record[3] !== "" ? $record[3] : null,
                    "rude" => $record[4],
                    "apellido_paterno" => $record[5],
                    "apellido_materno" => $record[6],
                    "nombres" => $record[7],
                    "ci" => $record[8] !== "" ? $record[8] : null,
                    "complemento" => $record[9],
                    "expedido" => $record[10],
                    "fecha_nacimiento" => $record[11],
                    "sexo" => $record[12],
                    "segip" => $record[13],
                    "distrito" => $record[14],
                    "zona" => $record[15],
                    "direccion" => $record[16],
                    "nota_promedio" => $record[17] !== "" ? $record[17] : 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                Estudiante::create($estudiante);
            }
            $heading = false;
        }
        fclose($input_file);       //

        /*         DB::table('unidades_educativas')->insert([ */
        /*             'codigo' => 80480002, */
        /*             'unidad_educativa' => 'JORGE REVILLA ALDANA B', */
        /*             'distrito' => '1001-SUCRE', */
        /*             'zona' => 'ALTO DELICIAS', */
        /*             'direccion' => 'CALLE JOAQUIN GANTIER VALDA S/N', */
        /*             'codigo_departamento' => 1, */
        /*             'created_at' => now(), */
        /*             'updated_at' => now(), */
        /*         ]); */
    }
}
