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
        Schema::create('asesor', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->string('apellido', 50);
            $table->string('celular', 13);
            $table->unsignedBigInteger('id_autentication');
            $table->foreign('id_autentication')->references('id')->on('users');
            $table->unsignedBigInteger('id_aliado');
            $table->foreign('id_aliado')->references('id')->on('aliado');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesor');
    }
};
