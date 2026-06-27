<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SellerProfileSeeder extends Seeder
{
    public function run(): void
    {
        // Toko untuk seller demo 1
        DB::table('seller_profiles')->insert([
            'user_id'     => User::where('email', 'seller@tokoku.test')->first()->id,
            'store_name'  => 'Toko Demo Elektronik',
            'store_slug'  => 'toko-demo-elektronik',
            'description' => 'Toko elektronik terpercaya dengan produk berkualitas dan harga terjangkau. Melayani pengiriman ke seluruh Indonesia.',
            'city'        => 'Jakarta Selatan',
            'is_verified' => 1,
            'is_active'   => 1,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        // Toko untuk seller demo 2
        DB::table('seller_profiles')->insert([
            'user_id'     => User::where('email', 'seller2@tokoku.test')->first()->id,
            'store_name'  => 'Fashion Kekinian Store',
            'store_slug'  => 'fashion-kekinian-store',
            'description' => 'Pusat fashion pria dan wanita dengan koleksi terbaru. Produk original bergaransi.',
            'city'        => 'Bandung',
            'is_verified' => 1,
            'is_active'   => 1,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        // Toko untuk seller dummy lainnya
        $sellers = User::where('role', 'seller')
            ->whereNotIn('email', ['seller@tokoku.test', 'seller2@tokoku.test'])
            ->get();

        $cities = [
            'Surabaya', 'Medan', 'Semarang', 'Yogyakarta',
            'Makassar', 'Palembang', 'Depok', 'Bekasi'
        ];

        foreach ($sellers as $index => $seller) {
            $storeName = fake()->company() . ' Shop';
            DB::table('seller_profiles')->insert([
                'user_id'     => $seller->id,
                'store_name'  => $storeName,
                'store_slug'  => Str::slug($storeName) . '-' . ($index + 1),
                'description' => fake()->paragraph(2),
                'city'        => $cities[$index % count($cities)],
                'is_verified' => 1,
                'is_active'   => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
