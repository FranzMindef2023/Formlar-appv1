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
        Schema::create('centros_reclutamientos', function (Blueprint $table) {
            $table->id();
            $table->text('codigo');
            $table->text('regimiento');
            $table->unsignedBigInteger('codigo_division');
            $table->unsignedBigInteger('id_fuerza');
            $table->integer('prioridad');

            $table->foreign('codigo_division')->references('codigo')->on('divisions');
            $table->foreign('id_fuerza')->references('idfuerza')->on('fuerzas');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('centros_reclutamientos');
    }
};
