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
       Schema::create('fuerzas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->unique(); // Ej: Ejército, Armada, Fuerza Aérea
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::dropIfExists('fuerzas');
    }
};
