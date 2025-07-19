<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\BookLoan;
use App\Models\User;
use Carbon\Carbon;

class DashboardTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar categorias de exemplo
        $categories = [
            ['name' => 'Ficção Científica', 'slug' => 'ficcao-cientifica', 'description' => 'Livros de ficção científica', 'color' => '#3B82F6'],
            ['name' => 'Romance', 'slug' => 'romance', 'description' => 'Livros de romance', 'color' => '#EF4444'],
            ['name' => 'Suspense', 'slug' => 'suspense', 'description' => 'Livros de suspense', 'color' => '#8B5CF6'],
            ['name' => 'Biografia', 'slug' => 'biografia', 'description' => 'Biografias', 'color' => '#10B981'],
            ['name' => 'Técnico', 'slug' => 'tecnico', 'description' => 'Livros técnicos', 'color' => '#F59E0B'],
        ];

        foreach ($categories as $category) {
            BookCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        // Criar livros de exemplo
        $books = [
            [
                'title' => 'Duna',
                'author' => 'Frank Herbert',
                'isbn' => '9788576572777',
                'description' => 'Uma épica aventura de ficção científica',
                'publisher' => 'Aleph',
                'publication_year' => 1965,
                'genre' => 'Ficção Científica',
                'pages' => 688,
                'language' => 'Português',
                'condition' => 'good',
                'status' => 'available',
                'location' => 'Estante A-1',
                'price' => 49.90,
                'quantity' => 3,
                'available_quantity' => 2,
                'category' => 'ficcao-cientifica'
            ],
            [
                'title' => 'O Cortiço',
                'author' => 'Aluísio Azevedo',
                'isbn' => '9788594318602',
                'description' => 'Clássico da literatura brasileira',
                'publisher' => 'Martin Claret',
                'publication_year' => 1890,
                'genre' => 'Literatura Brasileira',
                'pages' => 304,
                'language' => 'Português',
                'condition' => 'excellent',
                'status' => 'available',
                'location' => 'Estante B-2',
                'price' => 29.90,
                'quantity' => 5,
                'available_quantity' => 4,
                'category' => 'romance'
            ],
            [
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'isbn' => '9780132350884',
                'description' => 'A Handbook of Agile Software Craftsmanship',
                'publisher' => 'Prentice Hall',
                'publication_year' => 2008,
                'genre' => 'Programação',
                'pages' => 464,
                'language' => 'Inglês',
                'condition' => 'good',
                'status' => 'available',
                'location' => 'Estante C-3',
                'price' => 159.90,
                'quantity' => 2,
                'available_quantity' => 1,
                'category' => 'tecnico'
            ],
            [
                'title' => 'Steve Jobs',
                'author' => 'Walter Isaacson',
                'isbn' => '9788535915501',
                'description' => 'A biografia autorizada de Steve Jobs',
                'publisher' => 'Companhia das Letras',
                'publication_year' => 2011,
                'genre' => 'Biografia',
                'pages' => 624,
                'language' => 'Português',
                'condition' => 'excellent',
                'status' => 'available',
                'location' => 'Estante D-4',
                'price' => 59.90,
                'quantity' => 4,
                'available_quantity' => 3,
                'category' => 'biografia'
            ],
            [
                'title' => 'O Código Da Vinci',
                'author' => 'Dan Brown',
                'isbn' => '9788575421086',
                'description' => 'Thriller de suspense histórico',
                'publisher' => 'Arqueiro',
                'publication_year' => 2003,
                'genre' => 'Suspense',
                'pages' => 432,
                'language' => 'Português',
                'condition' => 'good',
                'status' => 'available',
                'location' => 'Estante E-5',
                'price' => 39.90,
                'quantity' => 3,
                'available_quantity' => 2,
                'category' => 'suspense'
            ],
        ];

        foreach ($books as $bookData) {
            $categorySlug = $bookData['category'];
            unset($bookData['category']);
            
            $book = Book::updateOrCreate(
                ['isbn' => $bookData['isbn']],
                $bookData
            );

            // Associar categoria ao livro
            $category = BookCategory::where('slug', $categorySlug)->first();
            if ($category) {
                $book->categories()->syncWithoutDetaching([$category->id]);
            }
        }

        // Criar alguns usuários de exemplo
        $users = [
            ['name' => 'João Silva', 'email' => 'joao@example.com', 'password' => bcrypt('password'), 'user_type' => 'student'],
            ['name' => 'Maria Santos', 'email' => 'maria@example.com', 'password' => bcrypt('password'), 'user_type' => 'student'],
            ['name' => 'Pedro Oliveira', 'email' => 'pedro@example.com', 'password' => bcrypt('password'), 'user_type' => 'student'],
            ['name' => 'Ana Costa', 'email' => 'ana@example.com', 'password' => bcrypt('password'), 'user_type' => 'student'],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        // Criar alguns empréstimos de exemplo
        $books = Book::all();
        $users = User::where('user_type', 'student')->get();
        $admin = User::where('user_type', 'admin')->first();

        if ($admin && $users->count() > 0 && $books->count() > 0) {
            // Empréstimos ativos
            BookLoan::updateOrCreate(
                ['book_id' => $books[0]->id, 'user_id' => $users[0]->id],
                [
                    'approved_by' => $admin->id,
                    'loan_date' => Carbon::now()->subDays(5),
                    'due_date' => Carbon::now()->addDays(9),
                    'status' => 'active',
                    'renewal_count' => 0,
                    'max_renewals' => 2,
                ]
            );

            BookLoan::updateOrCreate(
                ['book_id' => $books[2]->id, 'user_id' => $users[1]->id],
                [
                    'approved_by' => $admin->id,
                    'loan_date' => Carbon::now()->subDays(3),
                    'due_date' => Carbon::now()->addDays(11),
                    'status' => 'active',
                    'renewal_count' => 0,
                    'max_renewals' => 2,
                ]
            );

            // Empréstimo atrasado
            BookLoan::updateOrCreate(
                ['book_id' => $books[4]->id, 'user_id' => $users[2]->id],
                [
                    'approved_by' => $admin->id,
                    'loan_date' => Carbon::now()->subDays(20),
                    'due_date' => Carbon::now()->subDays(6),
                    'status' => 'active',
                    'renewal_count' => 1,
                    'max_renewals' => 2,
                    'fine_amount' => 6.00,
                    'fine_paid' => false,
                ]
            );

            // Empréstimo devolvido
            BookLoan::updateOrCreate(
                ['book_id' => $books[1]->id, 'user_id' => $users[3]->id],
                [
                    'approved_by' => $admin->id,
                    'loan_date' => Carbon::now()->subDays(25),
                    'due_date' => Carbon::now()->subDays(11),
                    'return_date' => Carbon::now()->subDays(12),
                    'status' => 'returned',
                    'renewal_count' => 0,
                    'max_renewals' => 2,
                ]
            );

            // Mais alguns empréstimos devolvidos para estatísticas
            BookLoan::updateOrCreate(
                ['book_id' => $books[0]->id, 'user_id' => $users[1]->id],
                [
                    'approved_by' => $admin->id,
                    'loan_date' => Carbon::now()->subDays(40),
                    'due_date' => Carbon::now()->subDays(26),
                    'return_date' => Carbon::now()->subDays(27),
                    'status' => 'returned',
                    'renewal_count' => 1,
                    'max_renewals' => 2,
                ]
            );

            BookLoan::updateOrCreate(
                ['book_id' => $books[3]->id, 'user_id' => $users[0]->id],
                [
                    'approved_by' => $admin->id,
                    'loan_date' => Carbon::now()->subDays(35),
                    'due_date' => Carbon::now()->subDays(21),
                    'return_date' => Carbon::now()->subDays(22),
                    'status' => 'returned',
                    'renewal_count' => 0,
                    'max_renewals' => 2,
                ]
            );
        }
    }
}
