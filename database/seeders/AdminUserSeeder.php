<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@biblioteca.com'],
            [
                'name' => 'Administrador',
                'email' => 'admin@biblioteca.com',
                'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
                'phone' => '(11) 99999-9999',
                'cpf' => '000.000.000-00',
                'address' => 'Endereço da Biblioteca',
                'user_type' => 'admin',
                'is_active' => true,
                'max_books_allowed' => 10,
                'email_verified_at' => now(),
            ]
        );
    }
}
