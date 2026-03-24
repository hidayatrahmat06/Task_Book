<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Fiksi',
                'description' => 'Buku cerita dan novel fiksi dari berbagai genre',
            ],
            [
                'name' => 'Non-Fiksi',
                'description' => 'Buku pengetahuan, biografi, dan referensi',
            ],
            [
                'name' => 'Sains & Teknologi',
                'description' => 'Buku tentang ilmu pengetahuan dan teknologi',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
