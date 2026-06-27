<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Elektronik',         'icon' => '💻'],
            ['name' => 'Fashion Pria',        'icon' => '👔'],
            ['name' => 'Fashion Wanita',      'icon' => '👗'],
            ['name' => 'Makanan & Minuman',   'icon' => '🍜'],
            ['name' => 'Kesehatan & Kecantikan', 'icon' => '💊'],
            ['name' => 'Rumah & Dapur',       'icon' => '🏠'],
            ['name' => 'Olahraga',            'icon' => '⚽'],
            ['name' => 'Otomotif',            'icon' => '🚗'],
            ['name' => 'Buku & Alat Tulis',   'icon' => '📚'],
            ['name' => 'Mainan & Hobi',       'icon' => '🎮'],
            ['name' => 'Handphone & Tablet',  'icon' => '📱'],
            ['name' => 'Komputer & Laptop',   'icon' => '🖥️'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name'       => $category['name'],
                'slug'       => Str::slug($category['name']),
                'icon'       => $category['icon'],
                'is_active'  => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
