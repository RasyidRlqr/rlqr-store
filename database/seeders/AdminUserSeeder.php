<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Pastikan Model User sudah di-import
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun ADMIN
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@toko.com', // Ganti dengan email Anda
            'password' => Hash::make('password123'), // Ganti dengan password yang kuat!
            'role' => 1, // 1 = ADMIN (untuk middleware is_admin)
        ]);

        // 2. Akun USER BIASA
        User::create([
            'name' => 'User Biasa',
            'email' => 'user@toko.com',
            'password' => Hash::make('password123'),
            'role' => 0, // 0 = User Biasa
        ]);

        $this->command->info('Admin dan User Biasa berhasil dibuat!');
    }
}  