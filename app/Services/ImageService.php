<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class ImageService
{
    private ?ImageManager $manager = null;

    public function __construct()
    {
        if (extension_loaded('gd') || extension_loaded('imagick')) {
            $this->manager = ImageManager::gd();
        }
    }

    public function uploadAndResize(UploadedFile $file, string $directory, string $disk = 'public', int $maxWidth = 1200, int $quality = 80): string
    {
        if ($this->manager) {
            $filename = uniqid() . '_' . time() . '.webp';
            $path = $directory . '/' . $filename;

            $image = $this->manager->read($file->getRealPath());

            if ($image->width() > $maxWidth) {
                $image->scale(width: $maxWidth);
            }

            $encoded = $image->toWebp(quality: $quality);

            Storage::disk($disk)->put($path, $encoded);

            return $path;
        }

        return $file->store($directory, $disk);
    }

    public function uploadAvatar(UploadedFile $file): string
    {
        return $this->uploadAndResize($file, 'avatars', 'public', 300, 80);
    }

    public function uploadProductImage(UploadedFile $file): string
    {
        return $this->uploadAndResize($file, 'products', 'public', 1200, 80);
    }

    public function uploadBanner(UploadedFile $file): string
    {
        return $this->uploadAndResize($file, 'banners', 'public', 1920, 80);
    }

    public function uploadStoreLogo(UploadedFile $file): string
    {
        return $this->uploadAndResize($file, 'stores/logos', 'public', 300, 80);
    }

    public function uploadStoreBanner(UploadedFile $file): string
    {
        return $this->uploadAndResize($file, 'stores/banners', 'public', 1200, 80);
    }

    public function deleteIfExists(?string $path, string $disk = 'public'): void
    {
        if ($path && Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->delete($path);
        }
    }
}
