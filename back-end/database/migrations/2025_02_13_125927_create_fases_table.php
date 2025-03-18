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
        Schema::create('fases', function (Blueprint $table) {
            $table->id();                  // PK
            $table->integer('numero')->unique();     // Número da fase (ex.: 1, 2, 3)
            $table->string('descricao')->nullable(); // Descrição (opcional)
            $table->timestamps();          // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fases');
    }
};
