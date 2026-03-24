<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'borrow_date',
        'due_date',
        'return_date',
        'status',
        'fine_amount',
        'notes',
    ];

    protected $casts = [
        'borrow_date' => 'datetime',
        'due_date' => 'datetime',
        'return_date' => 'datetime',
    ];

    const DAILY_FINE = 1000; // Rp 1.000 per hari

    /**
     * Get the user that made the borrowing.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book that was borrowed.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Calculate fine for overdue books.
     * Rp 1.000 per hari keterlambatan.
     */
    public function calculateFine(): int
    {
        if ($this->status === 'returned' || $this->status === 'borrowed') {
            return $this->fine_amount;
        }

        if ($this->status === 'overdue') {
            $daysOverdue = Carbon::now()->diffInDays($this->due_date);
            return max(0, $daysOverdue * self::DAILY_FINE);
        }

        return 0;
    }

    /**
     * Get days overdue (negative if not overdue).
     */
    public function getDaysOverdueAttribute(): int
    {
        if ($this->status !== 'overdue') {
            return 0;
        }

        return Carbon::now()->diffInDays($this->due_date, false);
    }

    /**
     * Get human-readable status in Indonesian.
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'borrowed' => 'Sedang Dipinjam',
            'returned' => 'Sudah Dikembalikan',
            'overdue' => 'Terlambat',
            default => 'Tidak Diketahui',
        };
    }

    /**
     * Mark book as returned.
     */
    public function markAsReturned(): bool
    {
        // Calculate fine if returned late
        if (Carbon::now()->isAfter($this->due_date)) {
            $daysLate = Carbon::now()->diffInDays($this->due_date);
            $this->fine_amount = $daysLate * self::DAILY_FINE;
        }

        $this->return_date = Carbon::now();
        $this->status = 'returned';

        return $this->save();
    }

    /**
     * Check if borrowing is currently overdue.
     */
    public function isOverdue(): bool
    {
        return $this->status === 'overdue' || 
               (is_null($this->return_date) && Carbon::now()->isAfter($this->due_date));
    }
}
