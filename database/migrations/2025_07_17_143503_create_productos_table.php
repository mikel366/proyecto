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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            /*
            nombre	VARCHAR(100)	NOT NULL
            stock	INTEGER UNSIGNED	NOT NULL, default 0
            codigo_barra	VARCHAR(50)	UNIQUE, NULLABLE
            precio	DECIMAL(10,2)	NOT NULL

             */

            $table->string('nombre', 100)->nullable(false);
            $table->unsignedInteger('stock')->default(0);
            $table->string('codigo_barra', 50)->unique()->nullable();
            $table->decimal('precio', 10, 2)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
