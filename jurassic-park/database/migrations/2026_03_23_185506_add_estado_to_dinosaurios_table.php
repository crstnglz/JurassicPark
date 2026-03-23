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
        Schema::table('dinosaurios', function (Blueprint $table) {
            $table->enum('estado', ['activo', 'fugado', 'herido'])->default('activo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dinosaurios', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
};
