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
        Schema::create('book_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->date('reservation_date');
            $table->date('expiry_date'); // Data limite para retirar o livro
            $table->enum('status', ['active', 'fulfilled', 'expired', 'cancelled'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamp('notified_at')->nullable(); // Quando foi notificado que o livro está disponível
            $table->timestamps();
            
            // Índices
            $table->index(['user_id', 'status']);
            $table->index(['book_id', 'status']);
            $table->index('expiry_date');
            $table->index('status');
            
            // Um usuário pode ter apenas uma reserva ativa por livro
            $table->unique(['user_id', 'book_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_reservations');
    }
};
