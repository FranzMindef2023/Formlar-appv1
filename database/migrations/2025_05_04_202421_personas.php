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
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('nombres', 100);
            $table->string('primer_apellido', 100)->nullable();
            $table->string('segundo_apellido', 100)->nullable();
            $table->string('ci', 20)->unique();
            $table->date('fecha_nacimiento');
            $table->boolean('status')->default(true); // Campo de estado activo/inactivo
        
            // Claves foráneas hacia ubicacion_geografica
            $table->unsignedBigInteger('id_departamento');
            $table->unsignedBigInteger('id_lugar_nacimiento');

        
            $table->unsignedBigInteger('id_centro_reclutamiento');
        
            $table->timestamps();
        
            // Relaciones foráneas corregidas
            $table->foreign('id_departamento')->references('idubigeo')->on('ubicacion_geografica');
            $table->foreign('id_lugar_nacimiento')->references('idubigeo')->on('ubicacion_geografica');
            $table->foreign('id_centro_reclutamiento')->references('id')->on('unidades_especiales');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
