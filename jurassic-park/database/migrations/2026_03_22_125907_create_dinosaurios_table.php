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
        Schema::create('dinosaurios', function (Blueprint $table) {
            $table->id();
            $table->string('nick');
            $table->enum('raza', [
                'Triceratops', 'Brachiosaurus', 'Stegosaurus', 'Ankylosaurus',
                'Parasaurolophus', 'Gallimimus', 'Oviraptor', 'Ornitholestes',
                'Therizinosaurus', 'Velociraptor', 'Dilophosaurus', 'Carnotaurus',
                'Allosaurus', 'Tyrannosaurus rex', 'Spinosaurus', 'Giganotosaurus',
                'Indominus rex'
            ]);
            $table->integer('edad');
            $table->enum('nivel_peligrosidad', ['bajo', 'medio', 'alto', 'muy_alto', 'extremo', 'critico']);
            $table->enum('dieta', ['herbivoro', 'omnivoro', 'carnivoro']);
            $table->foreignId('celda_id')->nullable()->constrained('celdas')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dinosaurios');
    }
};
