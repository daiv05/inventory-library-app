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
        Schema::create('inv_kardex', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_producto')
                ->constrained('prd_productos')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreignId('id_tipo_movimiento')
                ->constrained('ctl_tipos_movimientos')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreignId('id_usuario_registro')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_kardex');
    }
};
