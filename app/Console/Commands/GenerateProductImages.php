<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class GenerateProductImages extends Command
{
    protected $signature = 'products:generate-images';
    protected $description = 'Download and assign placeholder images to all products';

    private array $categoryImages = [
        'Elektronik' => [
            'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?w=600&q=80',
            'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=600&q=80',
            'https://images.unsplash.com/photo-1583394838336-acd9776a61fb?w=600&q=80',
            'https://images.unsplash.com/photo-1526170375885-4d9982052a4e?w=600&q=80',
            'https://images.unsplash.com/photo-1546868871-7041f09a97d3?w=600&q=80',
        ],
        'Handphone & Tablet' => [
            'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=600&q=80',
            'https://images.unsplash.com/photo-1565849904461-04a58ad377e0?w=600&q=80',
            'https://images.unsplash.com/photo-1601784551446-20c9e07cdbdb?w=600&q=80',
            'https://images.unsplash.com/photo-1583394838336-acd9776a61fb?w=600&q=80',
            'https://images.unsplash.com/photo-1609592424823-2a1a6f0f1c38?w=600&q=80',
        ],
        'Komputer & Laptop' => [
            'https://images.unsplash.com/photo-1496181133206-80ce9b39a859?w=600&q=80',
            'https://images.unsplash.com/photo-1527814050087-3793815479db?w=600&q=80',
            'https://images.unsplash.com/photo-1615663249855-7570a6b3c4c0?w=600&q=80',
            'https://images.unsplash.com/photo-1593642632559-0c6d3fc62ad0?w=600&q=80',
            'https://images.unsplash.com/photo-1593305841991-05c297ba4575?w=600&q=80',
        ],
        'Fashion Pria' => [
            'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=600&q=80',
            'https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?w=600&q=80',
            'https://images.unsplash.com/photo-1553746350-77a288b83dc9?w=600&q=80',
            'https://images.unsplash.com/photo-1551028719-10067b061ad0?w=600&q=80',
            'https://images.unsplash.com/photo-1542272604-787c3835535d?w=600&q=80',
        ],
        'Fashion Wanita' => [
            'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?w=600&q=80',
            'https://images.unsplash.com/photo-1551163943-3f6a855d1153?w=600&q=80',
            'https://images.unsplash.com/photo-1583846783214-7229a91b20ed?w=600&q=80',
            'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=600&q=80',
            'https://images.unsplash.com/photo-1582142306909-195724d33ffc?w=600&q=80',
        ],
        'Makanan & Minuman' => [
            'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=600&q=80',
            'https://images.unsplash.com/photo-1587049352846-c4ecf2c09a5a?w=600&q=80',
            'https://images.unsplash.com/photo-1598423618788-9b1c43f5c1b1?w=600&q=80',
            'https://images.unsplash.com/photo-1597481499750-3e6b22637e25?w=600&q=80',
            'https://images.unsplash.com/photo-1606914469633-7cfde5e2a7b2?w=600&q=80',
        ],
        'Kesehatan & Kecantikan' => [
            'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=600&q=80',
            'https://images.unsplash.com/photo-1570194065650-d99fb4bedf0a?w=600&q=80',
            'https://images.unsplash.com/photo-1571781926291-c477ebfd024b?w=600&q=80',
            'https://images.unsplash.com/photo-1620916566398-39f743682182?w=600&q=80',
            'https://images.unsplash.com/photo-1608228538273-3d431cfb5b7f?w=600&q=80',
        ],
        'Rumah & Dapur' => [
            'https://images.unsplash.com/photo-1556910103-1c02745aae4d?w=600&q=80',
            'https://images.unsplash.com/photo-1574269909862-7e1d70bb8078?w=600&q=80',
            'https://images.unsplash.com/photo-1505693416388-ac5ce068068c?w=600&q=80',
            'https://images.unsplash.com/photo-1590794056224-7a28bdf3b2ef?w=600&q=80',
            'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=600&q=80',
        ],
        'Olahraga' => [
            'https://images.unsplash.com/photo-1601925260368-ae2f83cf8b7f?w=600&q=80',
            'https://images.unsplash.com/photo-1517836357463-d25dfeac2938?w=600&q=80',
            'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&q=80',
            'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=600&q=80',
            'https://images.unsplash.com/photo-1593079831268-3384b0db009c?w=600&q=80',
        ],
        'Otomotif' => [
            'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=600&q=80',
            'https://images.unsplash.com/photo-1581922815-3b3c4c3c3c3c?w=600&q=80',
            'https://images.unsplash.com/photo-1601362840469-51e8531c8b9e?w=600&q=80',
            'https://images.unsplash.com/photo-1597007030739-6d2e7172ee9b?w=600&q=80',
            'https://images.unsplash.com/photo-1503376780353-7e66fb27dbeb?w=600&q=80',
        ],
        'Buku & Alat Tulis' => [
            'https://images.unsplash.com/photo-1531346878377-a5be20888e57?w=600&q=80',
            'https://images.unsplash.com/photo-1455390582262-4743b7e843eb?w=600&q=80',
            'https://images.unsplash.com/photo-1517842645767-c639042777db?w=600&q=80',
            'https://images.unsplash.com/photo-1549312792-2b3c40c6b3c3?w=600&q=80',
            'https://images.unsplash.com/photo-1583485088034-694b46a3e926?w=600&q=80',
        ],
        'Mainan & Hobi' => [
            'https://images.unsplash.com/photo-1558060370-d67947933b1b?w=600&q=80',
            'https://images.unsplash.com/photo-1587654780291-39c9404d746b?w=600&q=80',
            'https://images.unsplash.com/photo-1561591162-85c2346c3c3c?w=600&q=80',
            'https://images.unsplash.com/photo-1596461404954-3a3c3c3c3c3c?w=600&q=80',
            'https://images.unsplash.com/photo-1611604548038-cb7c3c3c3c3c?w=600&q=80',
        ],
    ];

    public function handle(): void
    {
        $this->info('Downloading product images...');

        $disk = Storage::disk('public');

        if (! $disk->exists('products')) {
            $disk->makeDirectory('products');
        }

        $products = Product::all();
        $bar = $this->output->createProgressBar($products->count());
        $bar->start();

        $downloaded = [];

        foreach ($products as $product) {
            $categoryName = $product->category->name;
            $urls = $this->categoryImages[$categoryName] ?? $this->categoryImages['Elektronik'];

            $images = [];
            $numImages = min(2, count($urls));

            for ($i = 0; $i < $numImages; $i++) {
                $url = $urls[$i];
                $cacheKey = md5($url);

                if (isset($downloaded[$cacheKey])) {
                    $images[] = $downloaded[$cacheKey];
                    continue;
                }

                $filename = 'products/' . $categoryName . '-' . $i . '-' . uniqid() . '.jpg';

                try {
                    $data = @file_get_contents($url);

                    if ($data !== false) {
                        $disk->put($filename, $data);
                        $downloaded[$cacheKey] = $filename;
                        $images[] = $filename;
                    } else {
                        $this->line("\n  Failed: {$url}");
                    }
                } catch (\Exception $e) {
                    $this->line("\n  Error: {$e->getMessage()}");
                }
            }

            if (! empty($images)) {
                $product->forceFill(['images' => $images])->save();
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Done! Downloaded ' . count($downloaded) . ' unique images.');
    }
}
