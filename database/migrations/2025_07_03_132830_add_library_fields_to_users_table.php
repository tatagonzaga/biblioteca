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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->text('address')->nullable()->after('phone');
            $table->string('cpf')->unique()->nullable()->after('address');
            $table->enum('user_type', ['user', 'admin'])->default('user')->after('cpf');
            $table->boolean('is_active')->default(true)->after('user_type');
            $table->date('birth_date')->nullable()->after('is_active');
            $table->integer('max_books_allowed')->default(3)->after('birth_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'address',
                'cpf',
                'user_type',
                'is_active',
                'birth_date',
                'max_books_allowed'
            ]);
        });
    }
};
