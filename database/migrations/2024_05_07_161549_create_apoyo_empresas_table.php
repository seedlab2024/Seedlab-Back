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
        Schema::create('apoyo_empresa', function (Blueprint $table) {
            $table->id();
            $table->integer('documento');
            $table->string('nombre', 50);
            $table->string('apellido', 50);
            $table->string('cargo', 50);
            $table->string('telefono', 10)->nullable();
            $table->string('celular', 13);
            $table->string('email');

            $table->unsignedBigInteger('id_tipo_documento');
            $table->foreign('id_tipo_documento')->references('id')->on('tipo_documento');

            $table->integer('id_empresa');
            $table->foreign('id_empresa')->references('documento')->on('empresa')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apoyo_empresa');
    }
};
