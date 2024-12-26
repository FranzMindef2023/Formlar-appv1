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
        Schema::create('unidades_educativas', function (Blueprint $table) {
            $table->id('codigo');
            $table->text('unidad_educativa');
            $table->text('distrito');
            $table->text('zona');
            $table->text('direccion');
            $table->unsignedBigInteger('codigo_departamento');


            $table->foreign('codigo_departamento')->references('codigo')->on('departamentos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidades_educativas');
    }
};
