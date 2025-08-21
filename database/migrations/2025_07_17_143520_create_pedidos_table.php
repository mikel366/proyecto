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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            /*
            user_id	BIGINT UNSIGNED	FK a usuarios(id), NOT NULL
            locacion_id	BIGINT UNSIGNED	FK a locaciones(id), NULLABLE (por si es venta por mostrador)
            estado_id	TINYINT UNSIGNED	FK a estado_pedidos(id), NOT NULL
            canal_venta_id	TINYINT UNSIGNED	FK a canal_venta(id), NOT NULL
            metodo_pago_id	TINYINT UNSIGNED	FK a metodos_pagos(id), NOT NULL
            caja_id	BIGINT UNSIGNED	FK a caja(id), NULLABLE (depende si se registró en caja o no)
            total	DECIMAL(10,2)	NOT NULL
            creado_en	TIMESTAMP	default CURRENT_TIMESTAMP

             */

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('locacion_id')->nullable();
            $table->foreign('locacion_id')->references('id')->on('locaciones')->onDelete('cascade');
            $table->unsignedBigInteger('estado_id');
            $table->foreign('estado_id')->references('id')->on('estado_pedidos')->onDelete('cascade');
            $table->unsignedBigInteger('canal_venta_id');
            $table->foreign('canal_venta_id')->references('id')->on('canal_ventas')->onDelete('cascade');
            $table->unsignedBigInteger('metodo_pago_id');
            $table->foreign('metodo_pago_id')->references('id')->on('metodo_pagos')->onDelete('cascade');
            $table->unsignedBigInteger('caja_id')->nullable();
            $table->foreign('caja_id')->references('id')->on('cajas')->onDelete('cascade');
            $table->decimal('total', 10, 2)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
