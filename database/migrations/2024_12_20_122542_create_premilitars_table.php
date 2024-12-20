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
        Schema::create('premilitars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('codigo_unidad_educativa');
            $table->text('rude');
            $table->text('apellido_paterno');
            $table->text('apellido_materno');
            $table->text('nombres');
            $table->unsignedBigInteger('ci');
            $table->text('complemento');
            $table->text('expedido');

            $table->date('fecha_nacimiento');
            $table->text('sexo');
            $table->text('segip');
            $table->decimal('nota_promedio', 11, 2);

            $table->unsignedInteger('edad_actual');
            $table->unsignedInteger('edad_estimada');

            $table->unsignedInteger('gestion');
            $table->unsignedInteger('correlativo');
            $table->unsignedInteger('fase');

            $table->text('oficio');

            $table->date('fecha_presentacion');
            $table->text('hora_presentacion');

            $table->boolean('invitado');
            $table->text('descripcion');

            $table->timestamp('fecha_registro');

            $table->timestamps();


            $table->foreign("codigo_unidad_educativa")->references('codigo')->on('unidades_educativas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('premilitars');
    }
};
