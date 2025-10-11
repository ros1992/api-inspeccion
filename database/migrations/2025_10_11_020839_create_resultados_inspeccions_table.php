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
        Schema::create('resultados_inspeccions', function (Blueprint $table) {
            $table->id('id_resultado');
            $table->foreignId('id_inspeccion')->constrained('inspecciones', 'id_inspeccion');
            $table->foreignId('id_actividad')->constrained('actividades', 'id_actividad');
            $table->string('valor_respuesta', 10)->nullable(); // 'B', 'M', o texto
            $table->text('observacion_item')->nullable();
            $table->timestamp('fecha');

            // Índice único para evitar duplicados
            $table->unique(['id_inspeccion', 'id_actividad']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resultados_inspeccions');
    }
};
