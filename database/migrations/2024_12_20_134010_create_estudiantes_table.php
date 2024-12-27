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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id("correlativo");

            $table->text("departamento");
            $table->text("unidad_educativa");
            $table->unsignedBigInteger("codigo")->nullable();

            $table->text("rude");
            $table->text("apellido_paterno");
            $table->text("apellido_materno");

            $table->text("nombres");
            $table->unsignedBigInteger("ci")->nullable();
            $table->text("complemento")->nullable();
            $table->text("expedido");

            $table->date("fecha_nacimiento");

            $table->text("sexo");
            $table->text("segip");
            $table->text("distrito");
            $table->text("zona");
            $table->text("direccion");

            $table->decimal("nota_promedio", 11, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
