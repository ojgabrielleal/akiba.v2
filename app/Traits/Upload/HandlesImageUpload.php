<?php

namespace App\Traits\Upload;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HandlesImageUpload
{
    public function uploadImage(string $subfolder, UploadedFile $file, string $disk = 'public', ?string $oldImagePath = null): string
    {
        if ($oldImagePath) {
            $this->deleteImage($oldImagePath, $disk);
        }

        $folder = 'images/' . trim($subfolder, '/');
        $ext = $file->getClientOriginalExtension() ?: 'dat'; 
        $name = (string) \Illuminate\Support\Str::uuid() . '.' . $ext;
        $path = $file->storeAs($folder, $name, $disk);
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