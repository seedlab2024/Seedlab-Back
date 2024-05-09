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
        Schema::create('contenido_leccions', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion');
            $table->text('fuente');
            $table->unsignedBigInteger('id_tipo_dato');
            $table->foreign('id_tipo_dato')->references('id')->on('tipo_datos');
            $table->unsignedBigInteger('id_leccion');
            $table->foreign('id_leccion')->references('id')->on('leccions');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contenido_leccions');
    }
};
