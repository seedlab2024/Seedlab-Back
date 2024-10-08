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
        Schema::create('nivel', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->unsignedBigInteger('id_actividad');
            $table->foreign('id_actividad')->references('id')->on('actividad');
            $table->unsignedBigInteger('id_asesor')->nullable();
            $table->foreign('id_asesor')->references('id')->on('asesor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nivel');
    }
};
