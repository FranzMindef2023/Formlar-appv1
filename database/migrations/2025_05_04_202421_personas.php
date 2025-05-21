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
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('nombres', 100);
            $table->string('primer_apellido', 100)->nullable();
            $table->string('segundo_apellido', 100)->nullable();
            $table->string('ci', 20)->unique();
            $table->string('complemento_ci', 10)->nullable();
            $table->string('expedido', 5)->nullable();
            $table->string('celular', 20);
            $table->string('gestion', 10); // Ej: '2025'
            $table->string('correo', 100)->nullable();
            $table->date('fecha_nacimiento');
            $table->enum('sexo', ['M', 'F'])->nullable();
            $table->string('direccion', 255)->nullable();
            $table->string('foto', 255)->nullable();
            $table->string('nacionalidad', 50)->default('BOLIVIANA');
            $table->uuid('uuid')->nullable()->unique();
            $table->unsignedBigInteger('creado_por')->nullable();
            $table->ipAddress('ip_registro')->nullable();
            $table->string('origen_registro', 50)->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
