<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateUnidadEducativa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Creamos la función del trigger
        DB::unprepared('
            CREATE OR REPLACE FUNCTION public.insert_unidad_educativa()
            RETURNS TRIGGER AS $$
            BEGIN
                INSERT INTO unidades_educativas (
                    codigo,
                    unidad_educativa,
                    distrito,
                    zona,
                    direccion,
                    codigo_departamento,
                    created_at,
                    updated_at
                )
                SELECT DISTINCT
                    NEW.codigo,
                    NEW.unidad_educativa,
                    NEW.distrito,
                    NEW.zona,
                    NEW.direccion,
                    SUBSTRING(NEW.departamento, 1, 1)::int8,
                    CURRENT_TIMESTAMP,
                    CURRENT_TIMESTAMP
                WHERE NOT EXISTS (
                    SELECT 1
                    FROM unidades_educativas
                    WHERE codigo = NEW.codigo
                    AND unidad_educativa = NEW.unidad_educativa
                );

                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ');

        // Creamos el trigger
        DB::unprepared('
            CREATE OR REPLACE TRIGGER after_insert_estudiante
                AFTER INSERT ON estudiantes
                FOR EACH ROW
                EXECUTE FUNCTION public.insert_unidad_educativa();
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Eliminamos el trigger
        DB::unprepared('DROP TRIGGER IF EXISTS after_insert_estudiante ON estudiantes');

        // Eliminamos la función
        DB::unprepared('DROP FUNCTION IF EXISTS insert_unidad_educativa');
    }
}
