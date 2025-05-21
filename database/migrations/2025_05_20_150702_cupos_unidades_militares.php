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
        Schema::create('cupos_unidades_militares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unidad_militar_id')
                ->constrained('unidades_militares')
                ->onDelete('restrict');

            $table->string('gestion', 10);
            $table->unsignedInteger('cupos');
            $table->unsignedInteger('ocupados')->default(0);
            // REMOVIDO: $table->unsignedInteger('disponibles')->virtualAs('cupos - ocupados');
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->unique(['unidad_militar_id', 'gestion']);
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       chema::dropIfExists('cupos_unidades_militares');
    }
};
