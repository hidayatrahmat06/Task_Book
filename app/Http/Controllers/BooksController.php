<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Http\Requests\BookRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BooksController extends Controller
{
    /**
     * Display a listing of the books.
     */
    public function index(Request $request): View
    {
        $query = Book::with('category');

        // Search by title or author
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        // Sort
        $sortBy = $request->input('sort', 'newest');
        if ($sortBy === 'oldest') {
            $query->oldest('created_at');
        } elseif ($sortBy === 'most-borrowed') {
            $query->withCount('borrowings')
                  ->orderBy('borrowings_count', 'desc');
        } else {
            $query->latest('created_at');
        }

        $books = $query->paginate(12);
        $categories = Category::all();

        return view('books.index', compact('books', 'categories'));
    }

    /**
     * Show the form for creating a new book (Admin only).
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    /**
     * Store a newly created book in storage (Admin only).
     */
    public function store(BookRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('books', 'public');
            $validated['cover_image'] = $path;
        }

        Book::create($validated);

        return redirect()->route('books.index')
                        ->with('success', 'Buku berhasil ditambahkan.');
    }

    /**
     * Display the specified book.
     */
    public function show(Book $book): View
    {
        $book->load('category', 'borrowings.user');
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified book (Admin only).
     */
    public function edit(Book $book): View
    {
        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified book in storage (Admin only).
     */
    public function update(BookRequest $request, Book $book): RedirectResponse
    {
        $validated = $request->validated();

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('books', 'public');
            $validated['cover_image'] = $path;
        }

        $book->update($validated);

        return redirect()->route('books.show', $book)
                        ->with('success', 'Buku berhasil diperbarui.');
    }

    /**
     * Remove the specified book from storage (Admin only).
     */
    public function destroy(Book $book): RedirectResponse
    {
        // Check if book has active borrowings
        if ($book->borrowings()->whereIn('status', ['borrowed', 'overdue'])->exists()) {
            return redirect()->route('books.index')
                            ->with('error', 'Buku tidak dapat dihapus karena masih sedang dipinjam.');
        }

        $book->delete();

        return redirect()->route('books.index')
                        ->with('success', 'Buku berhasil dihapus.');
    }
}
