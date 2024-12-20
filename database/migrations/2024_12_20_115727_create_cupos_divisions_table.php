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
        Schema::create('cupos_divisions', function (Blueprint $table) {
            $table->unsignedInteger("codigo_division");
            $table->unsignedBigInteger("cupos");
            $table->unsignedInteger("gestion_apertura");

            $table->foreign("codigo_division")->references("codigo")->on("divisions");
            $table->foreign("gestion_apertura")->references("gestion")->on("aperturas");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cupos_divisions');
    }
};
