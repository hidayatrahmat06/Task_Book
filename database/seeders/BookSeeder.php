<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            // Fiksi (4 books)
            [
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'isbn' => '978-979-756-418-4',
                'category_id' => Category::where('name', 'Fiksi')->first()->id,
                'publisher' => 'Bentang',
                'year_published' => 2005,
                'stock' => 5,
                'description' => 'Kisah inspiratif tentang perjalanan enam orang anak di sebuah desa di Belitung yang berjuang mencapai mimpi mereka.',
            ],
            [
                'title' => 'Negeri 5 Menara',
                'author' => 'Ahmad Fuadi',
                'isbn' => '978-979-226-996-3',
                'category_id' => Category::where('name', 'Fiksi')->first()->id,
                'publisher' => 'Gramedia',
                'year_published' => 2009,
                'stock' => 4,
                'description' => 'Petualangan seorang anak muda Indonesia yang belajar di pesantren tradisional Tarim, Yaman.',
            ],
            [
                'title' => 'Pulang',
                'author' => 'Leila S. Chudori',
                'isbn' => '978-602-1242-96-5',
                'category_id' => Category::where('name', 'Fiksi')->first()->id,
                'publisher' => 'KPG',
                'year_published' => 2012,
                'stock' => 3,
                'description' => 'Novel tentang sebuah keluarga yang terpancar karena diasingkan di berbagai kota di dunia.',
            ],
            [
                'title' => 'Sang Pemimpi',
                'author' => 'Andrea Hirata',
                'isbn' => '978-979-756-419-1',
                'category_id' => Category::where('name', 'Fiksi')->first()->id,
                'publisher' => 'Bentang',
                'year_published' => 2006,
                'stock' => 4,
                'description' => 'Kelanjutan kisah inspiratif dari Laskar Pelangi dengan petualangan yang lebih luas.',
            ],

            // Non-Fiksi (3 books)
            [
                'title' => 'Filosofi Teras',
                'author' => 'Henry Manampiring',
                'isbn' => '978-602-1242-71-2',
                'category_id' => Category::where('name', 'Non-Fiksi')->first()->id,
                'publisher' => 'KPG',
                'year_published' => 2017,
                'stock' => 7,
                'description' => 'Buku tentang kebijaksanaan praktis dari filosofi Stoa kuno yang relevan dengan kehidupan modern.',
            ],
            [
                'title' => 'Kaya Mulai dari Mulai',
                'author' => 'Robert T. Kiyosaki',
                'isbn' => '978-979-726-503-6',
                'category_id' => Category::where('name', 'Non-Fiksi')->first()->id,
                'publisher' => 'Gramedia',
                'year_published' => 2000,
                'stock' => 5,
                'description' => 'Buku tentang kecerdasan finansial dan cara membangun kekayaan sejak muda.',
            ],
            [
                'title' => 'Buku Pintar Wanita Karir',
                'author' => 'Dewi Lestari',
                'isbn' => '978-602-1130-16-7',
                'category_id' => Category::where('name', 'Non-Fiksi')->first()->id,
                'publisher' => 'Gramedia Pustaka',
                'year_published' => 2015,
                'stock' => 6,
                'description' => 'Panduan praktis bagi wanita untuk meraih kesuksesan dalam karir dan kehidupan pribadi.',
            ],

            // Sains & Teknologi (3 books)
            [
                'title' => 'Cosmos',
                'author' => 'Carl Sagan',
                'isbn' => '978-0-375-41269-3',
                'category_id' => Category::where('name', 'Sains & Teknologi')->first()->id,
                'publisher' => 'Random House',
                'year_published' => 1980,
                'stock' => 4,
                'description' => 'Petualangan intelektual yang menggabungkan sains, sejarah, dan filosofi untuk mengeksplorasi alam semesta.',
            ],
            [
                'title' => 'A Brief History of Time',
                'author' => 'Stephen Hawking',
                'isbn' => '978-0-553-38016-3',
                'category_id' => Category::where('name', 'Sains & Teknologi')->first()->id,
                'publisher' => 'Bantam',
                'year_published' => 1988,
                'stock' => 3,
                'description' => 'Penjelasan mendalam tentang alam semesta, waktu, dan relativitas dari salah satu fisikawan terbesar.',
            ],
            [
                'title' => 'The Elegant Universe',
                'author' => 'Brian Greene',
                'isbn' => '978-0-393-04688-5',
                'category_id' => Category::where('name', 'Sains & Teknologi')->first()->id,
                'publisher' => 'W.W. Norton',
                'year_published' => 1999,
                'stock' => 3,
                'description' => 'Penjelasan tentang teori string dan dimensi tersembunyi dalam fisika modern.',
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
