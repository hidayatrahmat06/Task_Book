<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin Library',
            'email' => 'admin@library.com',
            'password' => Hash::make('Admin123!'),
            'role' => 'admin',
            'phone' => '08123456789',
            'address' => 'Jl. Perpustakaan No. 123, Jakarta',
        ]);

        // Create member users
        $members = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'phone' => '08111111111',
                'address' => 'Jl. Merdeka No. 1, Jakarta',
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti@example.com',
                'phone' => '08122222222',
                'address' => 'Jl. Sudirman No. 5, Bandung',
            ],
            [
                'name' => 'Andi Wijaya',
                'email' => 'andi@example.com',
                'phone' => '08133333333',
                'address' => 'Jl. Ahmad Yani No. 10, Surabaya',
            ],
            [
                'name' => 'Rini Handayani',
                'email' => 'rini@example.com',
                'phone' => '08144444444',
                'address' => 'Jl. Gajah Mada No. 7, Medan',
            ],
            [
                'name' => 'Hendra Kusuma',
                'email' => 'hendra@example.com',
                'phone' => '08155555555',
                'address' => 'Jl. Diponegoro No. 12, Semarang',
            ],
        ];

        foreach ($members as $member) {
            User::create([
                'name' => $member['name'],
                'email' => $member['email'],
                'password' => Hash::make('password123'),
                'role' => 'member',
                'phone' => $member['phone'],
                'address' => $member['address'],
            ]);
        }
    }
}
