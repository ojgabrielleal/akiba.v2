<?php

namespace App\Traits\Upload;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

trait HandlesImageUpload
{
    public function uploadImage(string $subfolder, UploadedFile $file, string $disk = 'public', ?string $oldImagePath = null): string
    {
        if ($oldImagePath) {
            $this->deleteImage($oldImagePath, $disk);
        }

        $folder = 'images/' . trim($subfolder, '/');
        $name = (string) \Illuminate\Support\Str::uuid() . '.webp';
        $path = $folder . '/' . $name;

        // Cria o gerenciador com o driver GD
        $manager = new ImageManager(new Driver());

        // Lê e converte a imagem para WebP (qualidade 80)
        $image = $manager->read($file)->toWebp(80);

        // Salva no storage
        Storage::disk($disk)->put($path, (string) $image);

        return '/storage/' . $path;
    }

    public function deleteImage(string $imagePath, string $disk = 'public'): bool
    {
        $filePath = str_replace('/storage/', '', $imagePath);
        
        if (Storage::disk($disk)->exists($filePath)) {
            return Storage::disk($disk)->delete($filePath);
        }

        return false;
    }
}
