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
        Schema::create('prd_productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_categoria')
                ->constrained('prd_categorias')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreignId('id_estado')
                ->constrained('ctl_estados')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->string('nombre')->unique();
            $table->text('descripcion')->nullable();
            $table->decimal('precio_actual', 10, 2);
            $table->integer('stock_actual')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prd_productos');
    }
};
