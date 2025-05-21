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
        Schema::create('destinos_presentacion', function (Blueprint $table) {
            $table->id();
            $table->string('gestion', 10);
            $table->foreignId('persona_id')->constrained('personas')->onDelete('cascade');
            $table->unsignedBigInteger('id_departamento_presenta');
            $table->unsignedBigInteger('id_centro_reclutamiento');
            $table->boolean('status')->default(true);


            $table->foreign('id_departamento_presenta')->references('idubigeo')->on('ubicacion_geografica')->onDelete('restrict');
            $table->foreign('id_centro_reclutamiento')->references('id')->on('unidades_militares')->onDelete('restrict');


            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        chema::dropIfExists('destinos_presentacion');
    }
};
