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
        Schema::create('detalle_pedidos', function (Blueprint $table) {
            $table->id();
            /*
            pedido_id	BIGINT UNSIGNED	FK a pedidos(id), NOT NULL
            producto_id	BIGINT UNSIGNED	FK a productos(id), NOT NULL
            cantidad	INT UNSIGNED	NOT NULL, mayor a 0
            precio_unitario	DECIMAL(10,2)	NOT NULL
            subtotal	DECIMAL(10,2)	NOT NULL (cantidad * precio_unitario)

             */

            $table->unsignedBigInteger('pedido_id');
            $table->foreign('pedido_id')->references('id')->on('pedidos')->onDelete('cascade');
            $table->unsignedBigInteger('producto_id');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->unsignedInteger('cantidad')->nullable(false);
            $table->decimal('precio_unitario', 10, 2)->nullable(false);
            $table->decimal('subtotal', 10, 2)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_pedidos');
    }
};
