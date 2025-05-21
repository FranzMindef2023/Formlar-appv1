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
        Schema::create('ubicacion_geografica', function (Blueprint $table) {
            $table->id('idubigeo'); // Equivalente a bigserial
            $table->unsignedBigInteger('id_padre')->nullable(); // Referencia jerárquica
            $table->integer('ubigeo');
            $table->string('codigoubigeo', 20);
            $table->string('descubigeo', 100);
            $table->string('nivel', 5);
            $table->string('siglaubigeo', 30)->nullable();
            $table->timestamps();
        
            // Relación jerárquica a sí misma
            $table->foreign('id_padre')->references('idubigeo')->on('ubicacion_geografica')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ubicacion_geografica');
    }
};
