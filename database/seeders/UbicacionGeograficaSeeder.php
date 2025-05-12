<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UbicacionGeograficaSeeder extends Seeder
{
    public function run(): void
    {
        $departamentos = [
            ['idubigeo' => 1, 'id_padre' => null, 'ubigeo' => '01', 'codigoubigeo' => '01', 'descubigeo' => 'Chuquisaca',   'nivel' => 1, 'siglaubigeo' => 'CH'],
            ['idubigeo' => 2, 'id_padre' => null, 'ubigeo' => '02', 'codigoubigeo' => '02', 'descubigeo' => 'La Paz',       'nivel' => 1, 'siglaubigeo' => 'LP'],
            ['idubigeo' => 3, 'id_padre' => null, 'ubigeo' => '03', 'codigoubigeo' => '03', 'descubigeo' => 'Cochabamba',   'nivel' => 1, 'siglaubigeo' => 'CB'],
            ['idubigeo' => 4, 'id_padre' => null, 'ubigeo' => '04', 'codigoubigeo' => '04', 'descubigeo' => 'Oruro',        'nivel' => 1, 'siglaubigeo' => 'OR'],
            ['idubigeo' => 5, 'id_padre' => null, 'ubigeo' => '05', 'codigoubigeo' => '05', 'descubigeo' => 'Potosí',       'nivel' => 1, 'siglaubigeo' => 'PT'],
            ['idubigeo' => 6, 'id_padre' => null, 'ubigeo' => '06', 'codigoubigeo' => '06', 'descubigeo' => 'Tarija',       'nivel' => 1, 'siglaubigeo' => 'TJ'],
            ['idubigeo' => 7, 'id_padre' => null, 'ubigeo' => '07', 'codigoubigeo' => '07', 'descubigeo' => 'Santa Cruz',   'nivel' => 1, 'siglaubigeo' => 'SC'],
            ['idubigeo' => 8, 'id_padre' => null, 'ubigeo' => '08', 'codigoubigeo' => '08', 'descubigeo' => 'Beni',         'nivel' => 1, 'siglaubigeo' => 'BN'],
            ['idubigeo' => 9, 'id_padre' => null, 'ubigeo' => '09', 'codigoubigeo' => '09', 'descubigeo' => 'Pando',        'nivel' => 1, 'siglaubigeo' => 'PD'],
        ];

        $municipios = [];
        $id = 10;
        foreach ($departamentos as $dep) {
            for ($i = 1; $i <= 3; $i++) {
                $municipios[] = [
                    'idubigeo' => $id++,
                    'id_padre' => $dep['idubigeo'],
                    'ubigeo' => $dep['ubigeo'] . $i,
                    'codigoubigeo' => $dep['codigoubigeo'] . $i,
                    'descubigeo' => "Municipio {$i} de " . $dep['descubigeo'],
                    'nivel' => 2,
                    'siglaubigeo' => strtoupper(substr($dep['descubigeo'], 0, 3)) . $i
                ];
            }
        }

        DB::table('ubicacion_geografica')->insert(array_merge($departamentos, $municipios));
    }
}
