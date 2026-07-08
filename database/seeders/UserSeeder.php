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
        User::firstOrCreate(
            ['email' => 'admin@tokoku.test'],
            [
                'name'              => 'Admin TokoKu',
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
                'role'              => 'admin',
                'phone'             => '081234567890',
                'is_active'         => 1,
            ]
        );

        // Seller Demo
        User::firstOrCreate(
            ['email' => 'seller@tokoku.test'],
            [
                'name'              => 'Demo Seller',
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
                'role'              => 'seller',
                'phone'             => '082345678901',
                'is_active'         => 1,
            ]
        );

        // Seller Demo 2
        User::firstOrCreate(
            ['email' => 'seller2@tokoku.test'],
            [
                'name'              => 'Demo Seller Dua',
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
                'role'              => 'seller',
                'phone'             => '083456789012',
                'is_active'         => 1,
            ]
        );

        // Buyer Demo
        User::firstOrCreate(
            ['email' => 'buyer@tokoku.test'],
            [
                'name'              => 'Demo Buyer',
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
                'role'              => 'buyer',
                'phone'             => '084567890123',
                'is_active'         => 1,
            ]
        );

        // ==============================
        // DATA DUMMY TAMBAHAN
        // ==============================

        // 10 buyer dummy
        User::factory()->buyer()->count(10)->create();

        // 5 seller dummy
        User::factory()->seller()->count(5)->create();
    }
}
