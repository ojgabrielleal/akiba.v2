<?php

namespace App\Services\Process;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageService
{
    public function upload(string $subfolder, UploadedFile $file, string $disk = 'public', ?string $oldImagePath = null): string
    {
        if ($oldImagePath) {
            $this->delete($oldImagePath, $disk);
        }

        $folder = 'images/' . trim($subfolder, '/');
        $manager = new ImageManager(new Driver());

        // Check if the uploaded file is a GIF
        if (strtolower($file->extension()) === 'gif') {
            $extension = 'gif';
            $imageContent = $file->get();
        } else {
            // For other images, convert to WebP
            $extension = 'webp';
            $imageContent = $manager->read($file)->toWebp(85);
        }

        $name = (string) \Illuminate\Support\Str::uuid() . '.' . $extension;
        $path = $folder . '/' . $name;

        Storage::disk($disk)->put($path, (string) $imageContent);

        return '/storage/' . $path;
    }

    public function delete(string $imagePath, string $disk = 'public'): bool
    {
        $filePath = str_replace('/storage/', '', $imagePath);
        
        if (Storage::disk($disk)->exists($filePath)) {
            return Storage::disk($disk)->delete($filePath);
        }

        return false;
    }
}