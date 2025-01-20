<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Crear la función para el trigger
        DB::unprepared('
    CREATE OR REPLACE FUNCTION public.insert_premilitar()
    RETURNS TRIGGER AS $$
    BEGIN
        IF EXISTS (
            SELECT 1
            FROM unidades_educativas
            WHERE codigo = NEW.codigo
        )
        THEN
            INSERT INTO premilitars (
                codigo_unidad_educativa,
                rude,
                apellido_paterno,
                apellido_materno,
                nombres,
                ci,
                complemento,
                expedido,
                fecha_nacimiento,
                sexo,
                segip,
                nota_promedio,
                edad_actual,
                edad_estimada,
                gestion,
                correlativo,
                fase,
                oficio,
                fecha_presentacion,
                hora_presentacion,
                habilitado_edad,
                habilitado_notas,
                invitado,
                descripcion,
                fecha_registro,
                created_at,
                updated_at
            )
            VALUES (
                NEW.codigo,
                NEW.rude,
                NEW.apellido_paterno,
                NEW.apellido_materno,
                NEW.nombres,
                NEW.ci,
                NEW.complemento,
                NEW.expedido,
                NEW.fecha_nacimiento,
                NEW.sexo,
                NEW.segip,
                NEW.nota_promedio,
                EXTRACT(YEAR FROM AGE(CURRENT_DATE, NEW.fecha_nacimiento))::INT, -- Edad actual
                COALESCE(EXTRACT(YEAR FROM AGE((SELECT fecha_limite FROM aperturas LIMIT 1), NEW.fecha_nacimiento))::INT, 0), -- Edad estimada
                EXTRACT(YEAR FROM CURRENT_DATE)::INT, -- Gestion
                NEW.correlativo, -- Correlativo
                1, -- Fase
                \'Sin definir\', -- Oficio
                CURRENT_DATE, -- Fecha presentación
                CURRENT_TIME, -- Hora presentación

                COALESCE(
                    (
                        (COALESCE(EXTRACT(YEAR FROM AGE((SELECT fecha_limite FROM aperturas LIMIT 1), NEW.fecha_nacimiento))::INT, 0) BETWEEN
                        (SELECT edad_min FROM aperturas WHERE gestion = EXTRACT(YEAR FROM CURRENT_DATE)::INT LIMIT 1)
                        AND
                        (SELECT edad_max FROM aperturas WHERE gestion = EXTRACT(YEAR FROM CURRENT_DATE)::INT LIMIT 1))
                        AND
                        NEW.segip = \'Si\'
                    ),
                    false
                ),

                false, -- Habilitado por notas
                false, -- Invitado
                \'Registro automatico\', -- Descripción
                CURRENT_TIMESTAMP, -- Fecha registro
                CURRENT_TIMESTAMP, -- Created at
                CURRENT_TIMESTAMP -- Updated at
            );
        END IF;

        RETURN NEW;
    END;
    $$ LANGUAGE plpgsql;
');

        // Crear el trigger
        DB::unprepared('
            CREATE OR REPLACE TRIGGER after_insert_estudiante_premilitar
                AFTER INSERT ON estudiantes
                FOR EACH ROW
                EXECUTE FUNCTION public.insert_premilitar();
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Eliminar el trigger
        DB::unprepared('DROP TRIGGER IF EXISTS after_insert_estudiante_premilitar ON estudiantes');

        // Eliminar la función
        DB::unprepared('DROP FUNCTION IF EXISTS public.insert_premilitar');
    }
};
