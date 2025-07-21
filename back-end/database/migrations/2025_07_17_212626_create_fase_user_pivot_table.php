<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fase_user', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('fase_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('Não iniciado');
            $table->timestamps();

            // Chave primária para garantir que um usuário só tenha uma entrada por fase
            $table->primary(['user_id', 'fase_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fase_user');
    }
};
