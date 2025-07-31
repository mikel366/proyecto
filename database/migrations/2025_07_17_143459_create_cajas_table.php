<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cajas', function (Blueprint $table) {
            $table->id();
            /*
            usuario_id	BIGINT UNSIGNED	FK a usuarios(id), NOT NULL (quién abrió la caja)
            fecha_apertura	TIMESTAMP	default CURRENT_TIMESTAMP
            fecha_cierre	TIMESTAMP	NULLABLE (hasta que se cierre)
            monto_apertura	DECIMAL(10,2)	NULLABLE
            monto_cierre	DECIMAL(10,2)	NULLABLE
            estado_caja_id	TINYINT UNSIGNED	FK a estados_caja(id), NOT NULL
            observaciones	TEXT	NULLABLE

             */

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamp('fecha_apertura')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('fecha_cierre')->nullable();
            $table->decimal('monto_apertura', 10, 2)->nullable();
            $table->decimal('monto_cierre', 10, 2)->nullable();
            $table->unsignedBigInteger('estado_caja_id')->nullable();
            $table->foreign('estado_caja_id')->references('id')->on('estado_cajas')->onDelete('set null');
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cajas');
    }
};
