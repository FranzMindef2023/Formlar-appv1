<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class UbicacionGeograficaSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/data/ubicacion_geografica.csv');

        if (!file_exists($path)) {
            $this->command->error("Archivo CSV no encontrado en: {$path}");
            return;
        }

        $csv = Reader::createFromPath($path, 'r');
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);

        $registros = [];

        foreach ($csv->getRecords() as $record) {
            unset($record['created_at'], $record['updated_at']);
            $registros[] = $record;
        }

        DB::table('ubicacion_geografica')->insert($registros);
    }
}
