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
        Schema::create('livros', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 40);
            $table->string('editora', 40)->nullable();
            $table->unsignedInteger('edicao')->nullable();
            $table->string('ano_publicacao', 4);
            $table->integer('valor')->default(0);
            $table->timestamps();

            $table->index(['titulo','ano_publicacao']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livros');
    }
};
