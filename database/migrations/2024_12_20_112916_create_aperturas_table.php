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
        Schema::create('aperturas', function (Blueprint $table) {
            $table->id("gestion");
            $table->text("cantidad");
            $table->date("fecha_limite");
            $table->timestamp("fecha_apertura");
            $table->integer("edad_min");
            $table->integer("edad_max");
            $table->text("cite_junta");
            $table->text("firma_mae");

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aperturas');
    }
};
