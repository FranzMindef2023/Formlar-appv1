<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('asignaciones_presentacion', function (Blueprint $table) {
            $table->id();

            // Ubicación de residencia actual (puede ser municipio, distrito, etc.)
            $table->unsignedBigInteger('id_lugar_residencia');

            // Unidad militar asignada a esa zona
            $table->foreignId('unidad_militar_id')
                ->constrained('unidades_militares')
                ->onDelete('restrict');

            // NUEVO: Centro de presentación (opcional)
            $table->unsignedBigInteger('id_centro_presentacion')->nullable();

            // Gestión (año)
            $table->string('gestion', 10);

            // Fecha y hora en que debe presentarse el interesado
            $table->date('fecha_presentacion');
            $table->time('hora_presentacion');

            // Estado del vínculo
            $table->boolean('status')->default(true);

            $table->timestamps();

            // Relaciones foráneas
            $table->foreign('id_lugar_residencia')
                ->references('idubigeo')
                ->on('ubicacion_geografica')
                ->onDelete('restrict');

            $table->foreign('id_centro_presentacion')
                ->references('id')
                ->on('unidades_militares') // puedes cambiar a 'ubicacion_geografica' si lo prefieres
                ->onDelete('restrict');

            // NUEVA restricción para evitar duplicados por lugar + unidad + gestión
            $table->unique(['id_lugar_residencia', 'unidad_militar_id', 'gestion'], 'asignacion_unica');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       chema::dropIfExists('asignaciones_presentacion');
    }
};
