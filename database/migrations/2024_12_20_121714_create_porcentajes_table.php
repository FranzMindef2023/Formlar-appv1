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
        Schema::create('porcentajes', function (Blueprint $table) {
            $table->unsignedBigInteger('codigo_unidad_educativa');
            $table->unsignedBigInteger('id_centros_reclutamiento');

            $table->unsignedInteger('total_estudiantes');
            $table->unsignedInteger('total_hombres');
            $table->unsignedInteger('total_mujeres');
            $table->unsignedInteger('porcentaje_hombre');
            $table->unsignedInteger('porcentaje_mujer');
            $table->unsignedInteger('aceptados_hombres');
            $table->unsignedInteger('aceptados_mujeres');

            $table->unsignedInteger('total_aceptados');

            $table->integer('gestion');

            $table->foreign('codigo_unidad_educativa')->references('codigo')->on('unidades_educativas');
            $table->foreign('id_centros_reclutamiento')->references('id')->on('centros_reclutamientos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('porcentajes');
    }
};
