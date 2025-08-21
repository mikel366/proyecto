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
        Schema::create('locaciones', function (Blueprint $table) {
            $table->id();
            /*
            calle	VARCHAR(100)	NOT NULL
            numero	VARCHAR(20)	NOT NULL
            barrio	VARCHAR(100)	NOT NULL
            referencia	TEXT	NULLABLE
             */
            $table->string('calle', 100)->nullable(false);
            $table->string('numero', 20)->nullable(false);
            $table->string('barrio', 100)->nullable(false);
            $table->text('referencia')->nullable();
            $table->string('altitud', 20)->nullable(false);
            $table->string('longitud', 20)->nullable(false);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locaciones');
    }
};
