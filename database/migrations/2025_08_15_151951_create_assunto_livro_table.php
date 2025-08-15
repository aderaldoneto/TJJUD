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
        Schema::create('assunto_livro', function (Blueprint $table) {
            $table->unsignedBigInteger('assunto_id');
            $table->unsignedBigInteger('livro_id');

            $table->primary(['assunto_id', 'livro_id']);

            $table->foreign('assunto_id')->references('id')->on('assuntos')->cascadeOnDelete();
            $table->foreign('livro_id')->references('id')->on('livros')->cascadeOnDelete();

            $table->index('livro_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assunto_livro');
    }
};
