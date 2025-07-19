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
        Schema::create('book_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('color')->nullable(); // Cor para UI
            $table->string('icon')->nullable(); // Ícone para UI
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        
        // Criar tabela pivot para livros e categorias (um livro pode ter múltiplas categorias)
        Schema::create('book_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['book_id', 'book_category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_category');
        Schema::dropIfExists('book_categories');
    }
};
