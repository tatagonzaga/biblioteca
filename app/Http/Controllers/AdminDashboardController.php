<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookLoan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Estatísticas gerais
        $totalBooks = Book::count();
        $totalUsers = User::where('user_type', 'student')->count();
        $totalLoans = BookLoan::count();
        $activeLoans = BookLoan::whereIn('status', ['approved', 'active'])->count();
        $overdueLoans = BookLoan::where('status', 'active')
            ->where('due_date', '<', Carbon::now())
            ->count();
        
        // Livros disponíveis
        $availableBooks = Book::where('status', 'available')
            ->where('available_quantity', '>', 0)
            ->count();
        
        // Empréstimos por mês (últimos 6 meses)
        $loansPerMonth = BookLoan::select(
            DB::raw('MONTH(loan_date) as month'),
            DB::raw('YEAR(loan_date) as year'),
            DB::raw('COUNT(*) as total')
        )
        ->where('loan_date', '>=', Carbon::now()->subMonths(6))
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get();
        
        // Categorias mais emprestadas
        $topCategories = DB::table('book_loans')
            ->join('books', 'book_loans.book_id', '=', 'books.id')
            ->join('book_category', 'books.id', '=', 'book_category.book_id')
            ->join('book_categories', 'book_category.book_category_id', '=', 'book_categories.id')
            ->select('book_categories.name', DB::raw('COUNT(book_loans.id) as total'))
            ->groupBy('book_categories.id', 'book_categories.name')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        
        // Livros mais emprestados
        $topBooks = Book::select('books.title', 'books.author', DB::raw('COUNT(book_loans.id) as loan_count'))
            ->leftJoin('book_loans', 'books.id', '=', 'book_loans.book_id')
            ->groupBy('books.id', 'books.title', 'books.author')
            ->orderBy('loan_count', 'desc')
            ->limit(5)
            ->get();
        
        // Usuários mais ativos
        $activeUsers = User::select('users.name', 'users.email', DB::raw('COUNT(book_loans.id) as loan_count'))
            ->leftJoin('book_loans', 'users.id', '=', 'book_loans.user_id')
            ->where('users.user_type', 'student')
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderBy('loan_count', 'desc')
            ->limit(5)
            ->get();
        
        // Empréstimos recentes
        $recentLoans = BookLoan::with(['user', 'book'])
            ->orderBy('loan_date', 'desc')
            ->limit(5)
            ->get();
        
        // Multas pendentes
        $pendingFines = BookLoan::where('fine_amount', '>', 0)
            ->where('fine_paid', false)
            ->sum('fine_amount');
        
        return view('admin.dashboard', compact(
            'totalBooks',
            'totalUsers',
            'totalLoans',
            'activeLoans',
            'overdueLoans',
            'availableBooks',
            'loansPerMonth',
            'topCategories',
            'topBooks',
            'activeUsers',
            'recentLoans',
            'pendingFines'
        ));
    }
}
