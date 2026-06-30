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
        'Elektronik'           => ['https://picsum.photos/seed/elec1/600/600', 'https://picsum.photos/seed/elec2/600/600'],
        'Handphone & Tablet'   => ['https://picsum.photos/seed/phone1/600/600', 'https://picsum.photos/seed/phone2/600/600'],
        'Komputer & Laptop'    => ['https://picsum.photos/seed/laptop1/600/600', 'https://picsum.photos/seed/laptop2/600/600'],
        'Fashion Pria'         => ['https://picsum.photos/seed/men1/600/600', 'https://picsum.photos/seed/men2/600/600'],
        'Fashion Wanita'       => ['https://picsum.photos/seed/women1/600/600', 'https://picsum.photos/seed/women2/600/600'],
        'Makanan & Minuman'    => ['https://picsum.photos/seed/food1/600/600', 'https://picsum.photos/seed/food2/600/600'],
        'Kesehatan & Kecantikan' => ['https://picsum.photos/seed/beauty1/600/600', 'https://picsum.photos/seed/beauty2/600/600'],
        'Rumah & Dapur'        => ['https://picsum.photos/seed/home1/600/600', 'https://picsum.photos/seed/home2/600/600'],
        'Olahraga'             => ['https://picsum.photos/seed/sport1/600/600', 'https://picsum.photos/seed/sport2/600/600'],
        'Otomotif'             => ['https://picsum.photos/seed/auto1/600/600', 'https://picsum.photos/seed/auto2/600/600'],
        'Buku & Alat Tulis'    => ['https://picsum.photos/seed/book1/600/600', 'https://picsum.photos/seed/book2/600/600'],
        'Mainan & Hobi'        => ['https://picsum.photos/seed/toy1/600/600', 'https://picsum.photos/seed/toy2/600/600'],
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
