<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Borrowing;
use App\Models\User;
use App\Models\Book;
use Carbon\Carbon;

class BorrowingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'member')->get();
        $books = Book::all();

        $borrowings = [
            // Status: Borrowed (Sedang dipinjam - belum jatuh tempo)
            [
                'user_id' => $users[0]->id,
                'book_id' => $books->where('title', 'Laskar Pelangi')->first()->id,
                'borrow_date' => Carbon::now()->subDays(5),
                'due_date' => Carbon::now()->addDays(9),
                'return_date' => null,
                'status' => 'borrowed',
                'fine_amount' => 0,
                'notes' => 'Peminjaman reguler - durasi 14 hari',
            ],
            [
                'user_id' => $users[1]->id,
                'book_id' => $books->where('title', 'Filosofi Teras')->first()->id,
                'borrow_date' => Carbon::now()->subDays(3),
                'due_date' => Carbon::now()->addDays(11),
                'return_date' => null,
                'status' => 'borrowed',
                'fine_amount' => 0,
                'notes' => 'Untuk keperluan studi',
            ],

            // Status: Returned (Sudah dikembalikan - tepat waktu)
            [
                'user_id' => $users[2]->id,
                'book_id' => $books->where('title', 'Cosmos')->first()->id,
                'borrow_date' => Carbon::now()->subDays(20),
                'due_date' => Carbon::now()->subDays(6),
                'return_date' => Carbon::now()->subDays(6),
                'status' => 'returned',
                'fine_amount' => 0,
                'notes' => 'Dikembalikan tepat waktu',
            ],

            // Status: Returned (Sudah dikembalikan - dengan denda terlambat 2 hari)
            [
                'user_id' => $users[3]->id,
                'book_id' => $books->where('title', 'Negeri 5 Menara')->first()->id,
                'borrow_date' => Carbon::now()->subDays(18),
                'due_date' => Carbon::now()->subDays(4),
                'return_date' => Carbon::now()->subDays(2),
                'status' => 'returned',
                'fine_amount' => 2000,
                'notes' => 'Dikembalikan 2 hari terlambat - denda Rp 2.000',
            ],

            // Status: Overdue (Terlambat - masih belum dikembalikan)
            [
                'user_id' => $users[4]->id,
                'book_id' => $books->where('title', 'Kaya Mulai dari Mulai')->first()->id,
                'borrow_date' => Carbon::now()->subDays(20),
                'due_date' => Carbon::now()->subDays(6),
                'return_date' => null,
                'status' => 'overdue',
                'fine_amount' => 6000,
                'notes' => 'Terlambat 6 hari - denda Rp 6.000/hari',
            ],
        ];

        foreach ($borrowings as $borrowing) {
            Borrowing::create($borrowing);
        }
    }
}
