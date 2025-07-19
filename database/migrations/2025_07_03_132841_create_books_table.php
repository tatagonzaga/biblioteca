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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('isbn')->unique()->nullable();
            $table->text('description')->nullable();
            $table->string('publisher')->nullable();
            $table->year('publication_year')->nullable();
            $table->string('genre')->nullable();
            $table->integer('pages')->nullable();
            $table->string('language')->default('pt-BR');
            $table->enum('condition', ['new', 'good', 'fair', 'poor'])->default('good');
            $table->enum('status', ['available', 'borrowed', 'maintenance', 'lost'])->default('available');
            $table->string('location')->nullable(); // Localização física na biblioteca
            $table->string('cover_image')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->integer('quantity')->default(1);
            $table->integer('available_quantity')->default(1);
            $table->timestamps();
            
            // Índices para otimizar buscas
            $table->index(['title', 'author']);
            $table->index('status');
            $table->index('genre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
