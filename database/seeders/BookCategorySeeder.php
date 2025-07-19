<?php

namespace Database\Seeders;

use App\Models\BookCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Ficção',
                'description' => 'Livros de ficção em geral',
                'is_active' => true,
            ],
            [
                'name' => 'Romance',
                'description' => 'Livros de romance',
                'is_active' => true,
            ],
            [
                'name' => 'Suspense',
                'description' => 'Livros de suspense e mistério',
                'is_active' => true,
            ],
            [
                'name' => 'Fantasia',
                'description' => 'Livros de fantasia',
                'is_active' => true,
            ],
            [
                'name' => 'Ficção Científica',
                'description' => 'Livros de ficção científica',
                'is_active' => true,
            ],
            [
                'name' => 'Terror',
                'description' => 'Livros de terror e horror',
                'is_active' => true,
            ],
            [
                'name' => 'Biografia',
                'description' => 'Biografias e memórias',
                'is_active' => true,
            ],
            [
                'name' => 'História',
                'description' => 'Livros de história',
                'is_active' => true,
            ],
            [
                'name' => 'Ciência',
                'description' => 'Livros científicos e técnicos',
                'is_active' => true,
            ],
            [
                'name' => 'Autoajuda',
                'description' => 'Livros de autoajuda e desenvolvimento pessoal',
                'is_active' => true,
            ],
            [
                'name' => 'Negócios',
                'description' => 'Livros sobre negócios e economia',
                'is_active' => true,
            ],
            [
                'name' => 'Infantil',
                'description' => 'Livros infantis',
                'is_active' => true,
            ],
            [
                'name' => 'Juvenil',
                'description' => 'Livros juvenis',
                'is_active' => true,
            ],
            [
                'name' => 'Didático',
                'description' => 'Livros didáticos e educacionais',
                'is_active' => true,
            ],
            [
                'name' => 'Religioso',
                'description' => 'Livros religiosos e espirituais',
                'is_active' => true,
            ],
            [
                'name' => 'Poesia',
                'description' => 'Livros de poesia',
                'is_active' => true,
            ],
            [
                'name' => 'Drama',
                'description' => 'Peças teatrais e dramas',
                'is_active' => true,
            ],
            [
                'name' => 'Clássicos',
                'description' => 'Clássicos da literatura',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            BookCategory::create($category);
        }
    }
}
