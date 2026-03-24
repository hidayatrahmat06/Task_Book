<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Borrowing;
use App\Models\Category;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index(): View
    {
        if (auth()->user()->isAdmin()) {
            return $this->adminDashboard();
        }

        return $this->memberDashboard();
    }

    /**
     * Admin dashboard dengan statistik admin.
     */
    private function adminDashboard(): View
    {
        $stats = [
            'total_books' => Book::count(),
            'total_categories' => Category::count(),
            'total_users' => User::where('role', 'member')->count(),
            'total_borrowings' => Borrowing::count(),
            'active_borrowings' => Borrowing::whereIn('status', ['borrowed', 'overdue'])->count(),
            'overdue_borrowings' => Borrowing::where('status', 'overdue')->count(),
            'total_fine' => Borrowing::sum('fine_amount'),
        ];

        $recentBorrowings = Borrowing::with(['user', 'book'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $overdueBorrowings = Borrowing::with(['user', 'book'])
            ->where('status', 'overdue')
            ->orderBy('due_date')
            ->get();

        return view('dashboard.admin', compact('stats', 'recentBorrowings', 'overdueBorrowings'));
    }

    /**
     * Member dashboard dengan borrowings user.
     */
    private function memberDashboard(): View
    {
        $user = auth()->user();

        $myBorrowings = $user->borrowings()
            ->with('book.category')
            ->orderBy('created_at', 'desc')
            ->get();

        $activeBorrowings = $myBorrowings->filter(fn($b) => in_array($b->status, ['borrowed', 'overdue']));
        $returnedBorrowings = $myBorrowings->filter(fn($b) => $b->status === 'returned');

        $stats = [
            'active_count' => $activeBorrowings->count(),
            'returned_count' => $returnedBorrowings->count(),
            'total_fine' => $user->total_fine,
        ];

        return view('dashboard.member', compact('myBorrowings', 'stats', 'user'));
    }
}
