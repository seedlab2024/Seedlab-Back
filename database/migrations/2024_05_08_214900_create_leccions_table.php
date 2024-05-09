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
        Schema::create('leccions', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',50);
            $table->unsignedBigInteger('id_nivel');
            $table->foreign('id_nivel')->references('id')->on('nivels');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leccions');
    }
};
