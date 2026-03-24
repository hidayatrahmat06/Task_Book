<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'category_id',
        'publisher',
        'year_published',
        'stock',
        'description',
        'cover_image',
    ];

    /**
     * Get the category that the book belongs to.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the borrowings for the book.
     */
    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }

    /**
     * Check if book is available for borrowing.
     */
    public function isAvailable(): bool
    {
        return $this->stock > 0;
    }

    /**
     * Get available stock after borrowed books.
     */
    public function getAvailableStockAttribute(): int
    {
        return $this->stock - $this->borrowings()
            ->whereIn('status', ['borrowed', 'overdue'])
            ->count();
    }
}
