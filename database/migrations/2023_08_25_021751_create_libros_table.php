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
        Schema::create('libros', function (Blueprint $table) {
            $table->increments('idLibro');
            $table->string('titulo');
            $table->string('nombrePortada');
            $table->string('autor');
            $table->string('genero_Literario');
            $table->string('editorial');
            $table->string('ubicacion');
            $table->integer('ejemplares');
            $table->char('estado')->default('A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libros');
    }
};
