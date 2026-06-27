<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SellerProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $sellers     = SellerProfile::all();
        $categories  = Category::all();

        // Produk realistis per kategori
        $productData = [
            'Elektronik' => [
                ['name' => 'Smart TV LED 32 inch', 'price' => 2500000, 'weight' => 5000],
                ['name' => 'Speaker Bluetooth Portable', 'price' => 350000, 'weight' => 500],
                ['name' => 'Headphone Noise Cancelling', 'price' => 850000, 'weight' => 300],
                ['name' => 'Kipas Angin Mini USB', 'price' => 75000, 'weight' => 200],
                ['name' => 'Lampu LED RGB Smart', 'price' => 125000, 'weight' => 150],
            ],
            'Handphone & Tablet' => [
                ['name' => 'Smartphone 5G RAM 8GB', 'price' => 3500000, 'weight' => 300],
                ['name' => 'Tablet 10 inch WiFi', 'price' => 2200000, 'weight' => 600],
                ['name' => 'Case HP Anti Shock', 'price' => 45000, 'weight' => 100],
                ['name' => 'Charger Fast Charging 65W', 'price' => 150000, 'weight' => 200],
                ['name' => 'Powerbank 20000mAh', 'price' => 280000, 'weight' => 450],
            ],
            'Komputer & Laptop' => [
                ['name' => 'Laptop Core i5 Gen 12', 'price' => 8500000, 'weight' => 2000],
                ['name' => 'Mouse Wireless Ergonomis', 'price' => 180000, 'weight' => 150],
                ['name' => 'Keyboard Mechanical TKL', 'price' => 450000, 'weight' => 800],
                ['name' => 'Monitor 24 inch FHD', 'price' => 2200000, 'weight' => 4000],
                ['name' => 'SSD External 1TB', 'price' => 750000, 'weight' => 100],
            ],
            'Fashion Pria' => [
                ['name' => 'Kaos Polos Premium Cotton', 'price' => 85000, 'weight' => 200],
                ['name' => 'Kemeja Flannel Kotak-kotak', 'price' => 180000, 'weight' => 300],
                ['name' => 'Celana Jogger Panjang', 'price' => 150000, 'weight' => 400],
                ['name' => 'Jaket Hoodie Fleece', 'price' => 250000, 'weight' => 500],
                ['name' => 'Sepatu Sneakers Casual', 'price' => 450000, 'weight' => 800],
            ],
            'Fashion Wanita' => [
                ['name' => 'Dress Midi Floral', 'price' => 175000, 'weight' => 300],
                ['name' => 'Blouse Kancing Depan', 'price' => 120000, 'weight' => 200],
                ['name' => 'Rok A-Line Plisket', 'price' => 140000, 'weight' => 250],
                ['name' => 'Cardigan Rajut Tebal', 'price' => 220000, 'weight' => 400],
                ['name' => 'Tas Selempang Mini', 'price' => 195000, 'weight' => 350],
            ],
            'Makanan & Minuman' => [
                ['name' => 'Kopi Arabika Gayo 500gr', 'price' => 95000, 'weight' => 500],
                ['name' => 'Madu Hutan Murni 350ml', 'price' => 125000, 'weight' => 400],
                ['name' => 'Keripik Singkong Pedas 200gr', 'price' => 25000, 'weight' => 200],
                ['name' => 'Teh Hijau Organik 100gr', 'price' => 55000, 'weight' => 150],
                ['name' => 'Granola Oat Almond 500gr', 'price' => 85000, 'weight' => 500],
            ],
            'Kesehatan & Kecantikan' => [
                ['name' => 'Sunscreen SPF 50 PA+++', 'price' => 95000, 'weight' => 150],
                ['name' => 'Serum Vitamin C 30ml', 'price' => 145000, 'weight' => 100],
                ['name' => 'Masker Wajah Clay 100gr', 'price' => 65000, 'weight' => 150],
                ['name' => 'Sabun Mandi Cair 500ml', 'price' => 45000, 'weight' => 550],
                ['name' => 'Vitamin C 1000mg isi 30', 'price' => 75000, 'weight' => 200],
            ],
            'Rumah & Dapur' => [
                ['name' => 'Wajan Anti Lengket 28cm', 'price' => 185000, 'weight' => 800],
                ['name' => 'Blender 2 Tabung 600W', 'price' => 320000, 'weight' => 1500],
                ['name' => 'Tempat Tidur Lipat Dewasa', 'price' => 450000, 'weight' => 5000],
                ['name' => 'Rak Buku 5 Susun', 'price' => 380000, 'weight' => 8000],
                ['name' => 'Keset Microfiber Anti Slip', 'price' => 55000, 'weight' => 300],
            ],
            'Olahraga' => [
                ['name' => 'Matras Yoga 6mm Non Slip', 'price' => 165000, 'weight' => 1200],
                ['name' => 'Dumbbell Set 2kg x 2', 'price' => 120000, 'weight' => 4000],
                ['name' => 'Sepatu Lari Ringan', 'price' => 380000, 'weight' => 600],
                ['name' => 'Baju Olahraga Dryfit', 'price' => 145000, 'weight' => 250],
                ['name' => 'Jump Rope Speed Rope', 'price' => 55000, 'weight' => 200],
            ],
            'Otomotif' => [
                ['name' => 'Car Freshener Gantung', 'price' => 25000, 'weight' => 50],
                ['name' => 'Karpet Mobil All New', 'price' => 350000, 'weight' => 2000],
                ['name' => 'Charger Mobil USB-C PD', 'price' => 85000, 'weight' => 100],
                ['name' => 'Penutup Setir Bahan Kulit', 'price' => 95000, 'weight' => 300],
                ['name' => 'Kaca Film Anti Panas', 'price' => 250000, 'weight' => 500],
            ],
            'Buku & Alat Tulis' => [
                ['name' => 'Buku Catatan Hardcover A5', 'price' => 45000, 'weight' => 300],
                ['name' => 'Pulpen Gel Warna-warni isi 12', 'price' => 35000, 'weight' => 150],
                ['name' => 'Sticky Note 5 Warna 400 lembar', 'price' => 25000, 'weight' => 100],
                ['name' => 'Planner Bulanan 2025', 'price' => 75000, 'weight' => 400],
                ['name' => 'Highlighter Pastel Set 6', 'price' => 45000, 'weight' => 100],
            ],
            'Mainan & Hobi' => [
                ['name' => 'Lego Duplo 100 pcs', 'price' => 350000, 'weight' => 800],
                ['name' => 'Puzzle 1000 pcs Pemandangan', 'price' => 125000, 'weight' => 600],
                ['name' => 'Action Figure Karakter Anime', 'price' => 185000, 'weight' => 300],
                ['name' => 'Remote Control Car 4WD', 'price' => 275000, 'weight' => 700],
                ['name' => 'Ukulele Starter Pack', 'price' => 350000, 'weight' => 1000],
            ],
        ];

        foreach ($categories as $category) {
            $products = $productData[$category->name] ?? [];

            foreach ($products as $index => $product) {
                // Assign seller secara bergantian
                $seller = $sellers[$index % count($sellers)];

                $slug = Str::slug($product['name']) . '-' . $category->id . $index;

                DB::table('products')->insert([
                    'seller_profile_id' => $seller->id,
                    'category_id'    => $category->id,
                    'name'           => $product['name'],
                    'slug'           => $slug,
                    'description'    => $this->generateDescription($product['name']),
                    'price'          => $product['price'],
                    'stock'          => rand(10, 150),
                    'weight'         => $product['weight'],
                    'condition'      => 'new',
                    'status'         => 'active',
                    'total_sold'     => rand(0, 300),
                    'rating'         => round(rand(35, 50) / 10, 1),
                    'created_at'     => now()->subDays(rand(1, 90)),
                    'updated_at'     => now(),
                ]);
            }
        }
    }

    private function generateDescription(string $productName): string
    {
        return "**{$productName}** adalah produk berkualitas tinggi yang dirancang untuk memenuhi kebutuhan Anda sehari-hari.\n\n" .
            "Produk ini dibuat dengan bahan premium yang telah melalui proses quality control ketat. " .
            "Kami menjamin setiap produk yang kami kirimkan dalam kondisi sempurna dan siap pakai.\n\n" .
            "**Keunggulan produk:**\n" .
            "- Kualitas terjamin dan bergaransi\n" .
            "- Pengiriman aman dengan packaging bubble wrap\n" .
            "- Tersedia dalam beberapa pilihan varian\n" .
            "- Harga kompetitif langsung dari distributor\n\n" .
            "Jangan ragu untuk menghubungi toko kami jika ada pertanyaan lebih lanjut. Kami siap membantu!";
    }
}
