<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Book::with('categories');

        // Filtros de busca
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }

        $books = $query->orderBy('title')->paginate(12);
        $genres = Book::distinct()->pluck('genre')->filter();
        $statuses = ['available' => 'Disponível', 'borrowed' => 'Emprestado', 'maintenance' => 'Manutenção', 'lost' => 'Perdido'];

        return view('books.index', compact('books', 'genres', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = BookCategory::where('is_active', true)->get();
        return view('books.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|unique:books,isbn',
            'description' => 'nullable|string',
            'publisher' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'genre' => 'nullable|string|max:100',
            'pages' => 'nullable|integer|min:1',
            'language' => 'required|string|max:10',
            'condition' => 'required|in:new,good,fair,poor',
            'status' => 'required|in:available,borrowed,maintenance,lost',
            'location' => 'nullable|string|max:100',
            'price' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categories' => 'array',
            'categories.*' => 'exists:book_categories,id'
        ]);

        // Upload da imagem de capa
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('books/covers', 'public');
        }

        $validated['available_quantity'] = $validated['quantity'];

        $book = Book::create($validated);

        // Associar categorias
        if ($request->filled('categories') && is_array($request->categories)) {
            $book->categories()->attach($request->categories);
        }

        return redirect()->route('books.index')->with('success', 'Livro cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book->load('categories', 'loans.user', 'reservations.user');
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $categories = BookCategory::where('is_active', true)->get();
        $book->load('categories');
        return view('books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => ['nullable', 'string', Rule::unique('books', 'isbn')->ignore($book->id)],
            'description' => 'nullable|string',
            'publisher' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'genre' => 'nullable|string|max:100',
            'pages' => 'nullable|integer|min:1',
            'language' => 'required|string|max:10',
            'condition' => 'required|in:new,good,fair,poor',
            'status' => 'required|in:available,borrowed,maintenance,lost',
            'location' => 'nullable|string|max:100',
            'price' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categories' => 'array',
            'categories.*' => 'exists:book_categories,id'
        ]);

        // Upload da nova imagem de capa
        if ($request->hasFile('cover_image')) {
            // Deletar imagem antiga
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('books/covers', 'public');
        }

        // Atualizar quantidade disponível proporcionalmente
        if ($validated['quantity'] != $book->quantity) {
            $diff = $validated['quantity'] - $book->quantity;
            $validated['available_quantity'] = max(0, $book->available_quantity + $diff);
        }

        $book->update($validated);

        // Atualizar categorias
        if ($request->has('categories')) {
            $categories = is_array($request->categories) ? $request->categories : [];
            $book->categories()->sync($categories);
        }

        return redirect()->route('books.index')->with('success', 'Livro atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        // Verificar se o livro tem empréstimos ativos
        if ($book->loans()->whereIn('status', ['active', 'approved', 'pending'])->exists()) {
            return redirect()->route('books.index')->with('error', 'Não é possível excluir livro com empréstimos ativos.');
        }

        // Deletar imagem de capa
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Livro excluído com sucesso!');
    }
}
