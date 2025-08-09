<?php

namespace App\Traits\Upload;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HandlesImageUpload
{
    public function uploadImage(string $subfolder, UploadedFile $file, string $disk = 'public'): string
    {
        $folder = 'images/' . trim($subfolder, '/');
        $ext = $file->getClientOriginalExtension() ?: 'dat';
        $name = (string) \Illuminate\Support\Str::uuid() . '.' . $ext;

        $path = $file->storeAs($folder, $name, $disk);

        return '/storage/' . $path;
    }
}
