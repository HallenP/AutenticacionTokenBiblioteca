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
        Schema::create('prestamos', function (Blueprint $table) {
            $table->increments('IdPrestamo');
            $table->integer('IdUsuario');
            $table->integer('IdLibro');
            $table->date('FechaDevolucion');
            $table->date('FechaConfirmacionDevolucion');
            $table->string('Estado');
            $table->date('FechaCreacion');
            $table->char('estadoeliminacion')->default('A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
