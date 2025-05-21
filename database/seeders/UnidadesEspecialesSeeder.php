<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadesEspecialesSeeder extends Seeder
{
    public function run(): void
    {
        $unidades = [
            [
                'id' => 1,
                'codigo' => 'UE001',
                'descripcion' => 'Unidad Especial Chuquisaca',
                'id_ubicacion' => 10, // Municipio 1 de Chuquisaca
                'id_padre' => null,
                'status' => true,
            ],
            [
                'id' => 2,
                'codigo' => 'UE002',
                'descripcion' => 'Unidad Especial La Paz',
                'id_ubicacion' => 13, // Municipio 1 de La Paz
                'id_padre' => 1,
                'status' => true,
            ]
        ];

        DB::table('unidades_especiales')->insert($unidades);
    }
}
