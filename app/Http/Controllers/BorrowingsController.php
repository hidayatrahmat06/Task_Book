<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Carbon\Carbon;

class BorrowingsController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of borrowings (Admin) or user's borrowings (Member).
     */
    public function index(): View
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $borrowings = Borrowing::with(['user', 'book.category'])
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        } else {
            $borrowings = $user->borrowings()
                ->with('book.category')
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        }

        return view('borrowings.index', compact('borrowings'));
    }

    /**
     * Show borrow form.
     */
    public function create(): View
    {
        $books = Book::with('category')
            ->where('stock', '>', 0)
            ->orderBy('title')
            ->paginate(12);

        // Admin can see members list for creating borrowings on their behalf
        $users = collect();
        if (auth()->user()->isAdmin()) {
            $users = \App\Models\User::where('role', 'member')->orderBy('name')->get();
        }

        return view('borrowings.create', compact('books', 'users'));
    }

    /**
     * Store a new borrowing.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'nullable|exists:users,id', // For admin creating on behalf of member
        ]);

        $book = Book::find($validated['book_id']);
        
        // Determine which user is borrowing (member or selected by admin)
        if (auth()->user()->isAdmin() && $request->filled('user_id')) {
            $user = \App\Models\User::where('role', 'member')->find($validated['user_id']);
            if (!$user) {
                return back()->with('error', 'Anggota yang dipilih tidak valid.');
            }
        } else {
            $user = auth()->user();
        }

        // Check if book is available
        if ($book->stock <= 0) {
            return back()->with('error', 'Buku tidak tersedia untuk dipinjam.');
        }

        // Check if user already borrowed this book (not yet returned)
        $existingBorrow = $user->borrowings()
            ->where('book_id', $book->id)
            ->whereIn('status', ['borrowed', 'overdue'])
            ->exists();

        if ($existingBorrow) {
            return back()->with('error', 'Anggota ini sudah meminjam buku ini dan belum mengembalikannya.');
        }

        // Create borrowing record
        $borrowing = Borrowing::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'borrow_date' => Carbon::now(),
            'due_date' => Carbon::now()->addDays(14), // 14 hari peminjaman
            'status' => 'borrowed',
            'fine_amount' => 0,
            'notes' => 'Dipinjam melalui aplikasi',
        ]);

        // Decrease book stock
        $book->decrement('stock');

        return redirect()->route('borrowings.show', $borrowing)
                        ->with('success', 'Buku berhasil dipinjam. Tenggat waktu pengembalian: ' . $borrowing->due_date->format('d/m/Y'));
    }

    /**
     * Display the specified borrowing.
     */
    public function show(Borrowing $borrowing): View
    {
        // Authorization: user hanya bisa melihat borrowing mereka sendiri
        $this->authorize('view', $borrowing);

        $borrowing->load('user', 'book.category');

        return view('borrowings.show', compact('borrowing'));
    }

    /**
     * Return a borrowed book (Member returns, Admin can mark as returned).
     */
    public function return(Borrowing $borrowing): RedirectResponse
    {
        // Authorization
        $this->authorize('update', $borrowing);

        if ($borrowing->status === 'returned') {
            return back()->with('warning', 'Buku ini sudah dikembalikan sebelumnya.');
        }

        // Check if overdue and calculate fine
        if (Carbon::now()->isAfter($borrowing->due_date)) {
            $daysLate = Carbon::now()->diffInDays($borrowing->due_date);
            $borrowing->fine_amount = $daysLate * Borrowing::DAILY_FINE;
            $borrowing->status = 'overdue';
        }

        $borrowing->return_date = Carbon::now();
        $borrowing->status = 'returned';
        $borrowing->save();

        // Increase book stock
        $borrowing->book->increment('stock');

        $message = 'Buku berhasil dikembalikan.';
        if ($borrowing->fine_amount > 0) {
            $message .= ' Denda yang harus dibayar: Rp ' . number_format($borrowing->fine_amount);
        }

        return redirect()->route('borrowings.show', $borrowing)
                        ->with('success', $message);
    }

    /**
     * Delete a borrowing record (Admin only).
     */
    public function destroy(Borrowing $borrowing): RedirectResponse
    {
        $this->authorize('delete', $borrowing);

        // If not returned, increase stock back
        if ($borrowing->status !== 'returned') {
            $borrowing->book->increment('stock');
        }

        $borrowing->delete();

        return redirect()->route('borrowings.index')
                        ->with('success', 'Record peminjaman berhasil dihapus.');
    }
}
