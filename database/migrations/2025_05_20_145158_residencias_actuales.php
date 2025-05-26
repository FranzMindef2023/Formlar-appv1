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
        Schema::create('residencias_actuales', function (Blueprint $table) {
            $table->id();
            $table->string('gestion', 10);
            $table->foreignId('persona_id')->constrained('personas')->onDelete('cascade');
            $table->unsignedBigInteger('id_departamento');
            $table->unsignedBigInteger('id_lugar_recidencia');
            $table->string('direccion', 250); // <-- nuevo campo
            $table->boolean('status')->default(true);

            $table->foreign('id_departamento')->references('idubigeo')->on('ubicacion_geografica')->onDelete('restrict');
            $table->foreign('id_lugar_recidencia')->references('idubigeo')->on('ubicacion_geografica')->onDelete('restrict');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        chema::dropIfExists('residencias_actuales');
    }
};
