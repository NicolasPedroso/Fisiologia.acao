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
        Schema::create('perguntas', function (Blueprint $table) {
            $table->id();                                  // Chave primária
            $table->foreignId('fase_id')                   // FK para 'fases'
                  ->nullable()                             // Caso a pergunta não seja vinculada a fase
                  ->constrained('fases')                   // Referencia a tabela 'fases'
                  ->cascadeOnDelete();                     // Ao deletar uma fase, deleta perguntas relacionadas (opcional)

            $table->text('texto');                         // Enunciado da pergunta (obrigatório)
            $table->integer('dificuldade');                // 1, 2 ou 3
            $table->string('imagem')->nullable();          // Caminho/URL da imagem, opcional
            $table->string('video_link')->nullable();      // Link do vídeo, opcional

            $table->timestamps();                          // created_at e updated_at (Laravel)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perguntas');
    }
};
