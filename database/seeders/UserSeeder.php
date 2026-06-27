<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ==============================
        // AKUN DEMO (untuk testing & portofolio)
        // ==============================

        // Admin
        User::create([
            'name'              => 'Admin TokoKu',
            'email'             => 'admin@tokoku.test',
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'role'              => 'admin',
            'phone'             => '081234567890',
            'is_active'         => 1,
        ]);

        // Seller Demo
        User::create([
            'name'              => 'Demo Seller',
            'email'             => 'seller@tokoku.test',
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'role'              => 'seller',
            'phone'             => '082345678901',
            'is_active'         => 1,
        ]);

        // Seller Demo 2
        User::create([
            'name'              => 'Demo Seller Dua',
            'email'             => 'seller2@tokoku.test',
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'role'              => 'seller',
            'phone'             => '083456789012',
            'is_active'         => 1,
        ]);

        // Buyer Demo
        User::create([
            'name'              => 'Demo Buyer',
            'email'             => 'buyer@tokoku.test',
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'role'              => 'buyer',
            'phone'             => '084567890123',
            'is_active'         => 1,
        ]);

        // ==============================
        // DATA DUMMY TAMBAHAN
        // ==============================

        // 10 buyer dummy
        User::factory()->buyer()->count(10)->create();

        // 5 seller dummy
        User::factory()->seller()->count(5)->create();
    }
}
