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
        Schema::create('unidades_militares', function (Blueprint $table) {
            $table->id(); // id autoincremental
            $table->string('codigo', 20)->unique();
            $table->string('descripcion', 255);

            // Claves foráneas
            $table->unsignedBigInteger('id_ubicacion');
            $table->unsignedBigInteger('id_provincia'); // 🔼 Provincia en ubicación geográfica
            $table->unsignedBigInteger('id_padre')->nullable();
            $table->unsignedBigInteger('id_fuerza'); // 🔼 NUEVO campo: Fuerza militar (Ejército, Armada...)
            $table->boolean('es_centro_reclutamiento')->default(false);
            $table->date('fecha_presentacion')->nullable();
            $table->time('hora_presentacion')->nullable();

            $table->boolean('status')->default(true); // Campo de estado activo/inactivo

            $table->timestamps();
             $table->unsignedBigInteger('id_centro_reclutamiento');

            // Relaciones foráneas
            $table->foreign('id_ubicacion')->references('idubigeo')->on('ubicacion_geografica');
            $table->foreign('id_provincia')->references('idubigeo')->on('ubicacion_geografica');
            $table->foreign('id_fuerza')->references('id')->on('fuerzas'); // 🔼 Nueva FK hacia tabla fuerzas
            // $table->foreign('id_padre')->references('id')->on('unidades_militares')->onDelete('set null');
        });

        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidades_militares');
    }
};
