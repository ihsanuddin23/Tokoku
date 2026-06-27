<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'title'      => 'Promo Harbolnas 12.12 — Diskon Hingga 70%',
                'image_path' => null,
                'link'       => '/products?sort=terlaris',
                'order'      => 1,
                'is_active'  => 1,
            ],
            [
                'title'      => 'Flash Sale Elektronik — Berakhir Dalam 24 Jam',
                'image_path' => null,
                'link'       => '/products?category=elektronik',
                'order'      => 2,
                'is_active'  => 1,
            ],
            [
                'title'      => 'Gratis Ongkir ke Seluruh Indonesia',
                'image_path' => null,
                'link'       => '/products',
                'order'      => 3,
                'is_active'  => 1,
            ],
        ];

        foreach ($banners as $banner) {
            DB::table('banners')->insert([
                ...$banner,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
