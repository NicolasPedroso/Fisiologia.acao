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
        Schema::create('respostas', function (Blueprint $table) {
            $table->id();                                 // PK
            $table->foreignId('pergunta_id')              // FK p/ 'perguntas'
                  ->constrained('perguntas')
                  ->cascadeOnDelete();                    // Se excluir pergunta, exclui as respostas

            $table->text('texto');                        // Conteúdo da resposta
            $table->boolean('correta')->default(false);    // Indica se é a resposta correta

            $table->timestamps();                         // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respostas');
    }
};
