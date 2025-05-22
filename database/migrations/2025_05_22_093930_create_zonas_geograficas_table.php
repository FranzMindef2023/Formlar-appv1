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
        Schema::create('zonas_geograficas', function (Blueprint $table) {
            $table->id(); // ID autoincremental
            $table->string('nombre', 50)->unique(); // Altiplano, Valles, Llanos
            $table->text('descripcion')->nullable(); // Descripción opcional
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zonas_geograficas');
    }
};
