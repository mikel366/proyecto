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
        Schema::create('movimiento_cajas', function (Blueprint $table) {
            $table->id();
            
            /*
            caja_id	BIGINT UNSIGNED	FK a caja(id), NOT NULL
            tipo	ENUM('ingreso', 'egreso')	NOT NULL
            monto	DECIMAL(10,2)	NOT NULL, mayor a 0
            motivo	VARCHAR(255)	NOT NULL (ej: "venta mostrador", "retiro para cambio", "devolución")
            referencia_id	BIGINT UNSIGNED	NULLABLE (ID del modelo relacionado, como pedido, gasto, etc.)
            referencia_tipo	VARCHAR(100)	NULLABLE (nombre del modelo relacionado, ej: "Pedido", "Gasto")
            fecha	TIMESTAMP	default CURRENT_TIMESTAMP
            usuario_id	BIGINT UNSIGNED	FK a usuarios(id), NULLABLE (quién registró el movimiento)

            */

            $table->unsignedBigInteger('caja_id');
            $table->foreign('caja_id')->references('id')->on('cajas')->onDelete('cascade');
            $table->enum('tipo', ['ingreso', 'egreso'])->nullable(false);
            $table->decimal('monto', 10, 2)->nullable(false);
            $table->string('motivo', 255)->nullable(false);
            $table->unsignedBigInteger('referencia_id')->nullable();
            $table->string('referencia_tipo', 100)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimiento_cajas');
    }
};
