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
        // Esto crea la tabla 'categorias'
        Schema::create('categorias', function (Blueprint $table) {
            // ¡ESTA ES LA LÍNEA MÁGICA!
            // Crea una columna 'id' que es BIGINT, sin signo,
            // autoincremental y la clave primaria.
            $table->id();

            // Crea la columna 'nombre' de tipo VARCHAR y se asegura
            // de que no pueda haber dos categorías con el mismo nombre.
            $table->string('nombre')->unique();

            // Crea la columna 'fecha'
            $table->timestamp('fecha');

            // Laravel NO añadirá 'created_at' y 'updated_at' porque en tu
            // modelo (Categoria.php) ya le dijimos $timestamps = false;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
