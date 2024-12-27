<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            CREATE OR REPLACE VIEW vista_porcentajes AS
            SELECT
                ue.codigo AS codigo_unidad_educativa,
                COUNT(e.correlativo) AS total_estudiantes,
                COUNT(CASE WHEN e.sexo = \'MASCULINO\' THEN 1 END) AS total_hombres,
                COUNT(CASE WHEN e.sexo = \'FEMENINO\' THEN 1 END) AS total_mujeres,
                EXTRACT(YEAR FROM CURRENT_DATE) AS gestion
            FROM
                estudiantes e
            JOIN
                unidades_educativas ue ON e.codigo = ue.codigo
            GROUP BY
                ue.codigo;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP VIEW IF EXISTS vista_porcentajes');
    }
};
