<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookLoan;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookLoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = BookLoan::with(['book', 'user']);

        // Se não é admin, mostrar apenas os próprios empréstimos
        if (!auth()->user()->isAdmin()) {
            $query->where('user_id', auth()->id());
        }

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('book', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            })->orWhereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('overdue')) {
            $query->where('due_date', '<', Carbon::now())
                  ->where('status', 'active');
        }

        $loans = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('loans.index', compact('loans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => ['required', 'exists:books,id'],
            'user_id' => ['required', 'exists:users,id'],
            'due_date' => ['required', 'date', 'after:today'],
            'notes' => ['nullable', 'string'],
        ]);

        $book = Book::findOrFail($validated['book_id']);
        $user = User::findOrFail($validated['user_id']);

        // Verificar se o livro está disponível
        if ($book->available_quantity <= 0) {
            return redirect()->back()->with('error', 'Este livro não está disponível para empréstimo.');
        }

        // Verificar se o usuário não excedeu o limite
        if ($user->activeLoans()->count() >= $user->max_books_allowed) {
            return redirect()->back()->with('error', 'Usuário excedeu o limite de livros permitidos.');
        }

        // Verificar se o usuário já tem este livro emprestado
        $existingLoan = BookLoan::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->where('status', 'active')
            ->first();

        if ($existingLoan) {
            return redirect()->back()->with('error', 'Este usuário já possui este livro emprestado.');
        }

        // Criar o empréstimo
        $loan = BookLoan::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'approved_by' => auth()->id(),
            'loan_date' => Carbon::now(),
            'due_date' => Carbon::parse($validated['due_date']),
            'status' => 'active',
            'notes' => $validated['notes'],
        ]);

        // Atualizar quantidade disponível do livro
        $book->decrement('available_quantity');

        // Atualizar status do livro se não há mais exemplares
        if ($book->available_quantity <= 0) {
            $book->update(['status' => 'borrowed']);
        }

        return redirect()->route('books.show', $book)->with('success', 'Livro emprestado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(BookLoan $loan)
    {
        $loan->load(['book', 'user', 'approvedBy']);
        return view('loans.show', compact('loan'));
    }

    /**
     * Return a book (mark loan as returned).
     */
    public function returnBook(BookLoan $loan)
    {
        if ($loan->status !== 'active') {
            return redirect()->back()->with('error', 'Este empréstimo não está ativo.');
        }

        // Marcar como devolvido
        $loan->update([
            'status' => 'returned',
            'return_date' => Carbon::now(),
        ]);

        // Atualizar quantidade disponível do livro
        $book = $loan->book;
        $book->increment('available_quantity');

        // Atualizar status do livro se há exemplares disponíveis
        if ($book->available_quantity > 0 && $book->status === 'borrowed') {
            $book->update(['status' => 'available']);
        }

        return redirect()->back()->with('success', 'Livro devolvido com sucesso!');
    }

    /**
     * Renew a book loan.
     */
    public function renew(BookLoan $loan, Request $request)
    {
        $validated = $request->validate([
            'new_due_date' => ['required', 'date', 'after:today'],
        ]);

        if ($loan->status !== 'active') {
            return redirect()->back()->with('error', 'Este empréstimo não está ativo.');
        }

        if ($loan->renewal_count >= $loan->max_renewals) {
            return redirect()->back()->with('error', 'Este empréstimo já atingiu o limite de renovações.');
        }

        $loan->update([
            'due_date' => Carbon::parse($validated['new_due_date']),
            'renewal_count' => $loan->renewal_count + 1,
        ]);

        return redirect()->back()->with('success', 'Empréstimo renovado com sucesso!');
    }

    /**
     * Get overdue loans.
     */
    public function overdue()
    {
        $overdueLoans = BookLoan::with(['book', 'user'])
            ->where('due_date', '<', Carbon::now())
            ->where('status', 'active')
            ->orderBy('due_date')
            ->paginate(15);

        return view('loans.overdue', compact('overdueLoans'));
    }

    /**
     * Update loan status to overdue for loans past due date.
     */
    public function updateOverdueStatus()
    {
        $updatedCount = BookLoan::where('due_date', '<', Carbon::now())
            ->where('status', 'active')
            ->update(['status' => 'overdue']);

        return redirect()->back()->with('success', "Status atualizado para {$updatedCount} empréstimos em atraso.");
    }
}
