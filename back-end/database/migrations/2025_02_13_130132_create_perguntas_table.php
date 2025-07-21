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
            $table->id();
            $table->foreignId('fase_id')
                  ->constrained('fases')
                  ->cascadeOnDelete();

            $table->text('question');
            $table->string('image')->nullable();

            $table->enum('correct_answer', ['A', 'B', 'C', 'D']);

            $table->string('option_a');
            $table->string('option_b');
            $table->string('option_c');
            $table->string('option_d');


            $table->timestamps();
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
