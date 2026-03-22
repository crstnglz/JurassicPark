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
        Schema::create('celdas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('cantidad_animales')->default(0);
            $table->enum('nivel_peligrosidad', ['bajo', 'medio', 'alto', 'muy_alto', 'extremo', 'critico'])->default('bajo');
            $table->integer('averias_pendientes')->default(0);
            $table->integer('alimento')->default(0);
            $table->enum('nivel_seguridad', ['bajo', 'medio', 'alto'])->default('medio');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('celdas');
    }
};
