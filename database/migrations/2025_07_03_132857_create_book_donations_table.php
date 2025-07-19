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
        Schema::create('book_donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->foreignId('donated_by')->nullable()->constrained('users')->onDelete('set null'); // Quem doou
            $table->foreignId('received_by')->constrained('users')->onDelete('cascade'); // Admin que recebeu
            $table->string('donor_name')->nullable(); // Nome do doador (caso não seja usuário)
            $table->string('donor_email')->nullable();
            $table->string('donor_phone')->nullable();
            $table->date('donation_date');
            $table->enum('condition_received', ['new', 'good', 'fair', 'poor'])->default('good');
            $table->text('notes')->nullable();
            $table->decimal('estimated_value', 8, 2)->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected', 'processed'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
            
            // Índices
            $table->index(['donated_by', 'donation_date']);
            $table->index('donation_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_donations');
    }
};
