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
        Schema::create('inspecciones', function (Blueprint $table) {
            $table->id('id_inspeccion');
            $table->foreignId('id_user')->constrained('users', 'id');
            $table->foreignId('id_equipo')->constrained('equipos', 'id_equipo');
            $table->date('fecha_inspeccion');
            $table->date('periodo_desde');
            $table->date('periodo_hasta');
            $table->text('observaciones')->nullable();
            $table->string('firma_conductor', 255)->nullable(); // Path o base64
            $table->string('firma_responsable_sst', 255)->nullable(); // Path o base64
            $table->timestamp('fecha');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspecciones');
    }
};
