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
        Schema::create('prd_detalles_productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_producto')
                ->constrained('prd_productos')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreignId('id_autor')
                ->nullable()
                ->constrained('lib_autores')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreignId('id_genero')
                ->nullable()
                ->constrained('lib_generos')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->string('codigo_producto')->unique();
            $table->string('color')->nullable();
            $table->string('dimensiones')->nullable();
            $table->string('peso')->nullable();
            $table->string('material')->nullable();
            $table->string('isbn')->unique()->nullable();
            $table->string('anio_publicacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prd_detalles_productos');
    }
};
