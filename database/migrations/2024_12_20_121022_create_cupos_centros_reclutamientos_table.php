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
        Schema::create('cupos_centros_reclutamientos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_centros_reclutamiento');
            $table->unsignedBigInteger('codigo_division');

            $table->unsignedBigInteger('cupo');
            $table->unsignedBigInteger("gestion");

            $table->foreign('id_centros_reclutamiento')->references('id')->on('centros_reclutamientos');
            $table->foreign('codigo_division')->references('codigo')->on('divisions');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cupos_centros_reclutamientos');
    }
};
