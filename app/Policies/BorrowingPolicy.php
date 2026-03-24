<?php

namespace App\Policies;

use App\Models\Borrowing;
use App\Models\User;

class BorrowingPolicy
{
    /**
     * Determine if the user can view the borrowing.
     */
    public function view(User $user, Borrowing $borrowing): bool
    {
        // Admin dapat melihat semua, member hanya bisa melihat milik mereka
        return $user->isAdmin() || $user->id === $borrowing->user_id;
    }

    /**
     * Determine if the user can update the borrowing.
     */
    public function update(User $user, Borrowing $borrowing): bool
    {
        // Member bisa return buku mereka sendiri, admin bisa update apapun
        return $user->isAdmin() || $user->id === $borrowing->user_id;
    }

    /**
     * Determine if the user can delete the borrowing.
     */
    public function delete(User $user, Borrowing $borrowing): bool
    {
        // Hanya admin yang bisa delete borrowing records
        return $user->isAdmin();
    }
}
