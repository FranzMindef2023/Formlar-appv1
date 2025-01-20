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
        Schema::create('cupos_unidades_educativas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('centros_reclutamiento_id');
            $table->unsignedBigInteger('unidades_educativa_codigo');


            $table->unsignedInteger('cupos');
            $table->float('porcentaje_hombres');
            $table->float('porcentaje_mujeres');

            $table->unsignedInteger('aceptado_mujeres')->nullable();
            $table->unsignedInteger('aceptado_hombres')->nullable();

            $table->unsignedInteger('gestion');

            $table->foreign('centros_reclutamiento_id')->references('id')->on('centros_reclutamientos');
            $table->foreign('unidades_educativa_codigo')->references('codigo')->on('unidades_educativas');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cupos_unidades_educativas');
    }
};
