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
                (SELECT COUNT(p2.correlativo)
                 FROM premilitars p2
                 WHERE p2.codigo_unidad_educativa = ue.codigo) AS total_estudiantes,
                COUNT(p.correlativo) AS total_estudiantes_habilitados,
                COUNT(CASE WHEN p.sexo = \'MASCULINO\' THEN 1 END) AS total_hombres,
                COUNT(CASE WHEN p.sexo = \'FEMENINO\' THEN 1 END) AS total_mujeres,
                EXTRACT(YEAR FROM CURRENT_DATE) AS gestion
            FROM
                premilitars p
            JOIN
                unidades_educativas ue ON p.codigo_unidad_educativa = ue.codigo
            WHERE
                p.habilitado_edad
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
