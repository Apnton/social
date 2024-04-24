<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ImageServices
{
    public const STORAGE_DISK = 'public';

    public function storeImage(?UploadedFile $image, string $path): ?string
    {
        if (empty($image)) return null;
        $imageName = $this->generateImageName($image, $path);
        Storage::disk(self::STORAGE_DISK)->putFileAs('/', $image, $imageName);

        return $imageName;
    }

    public function storeWithResizeImage(?UploadedFile $image, string $path, ?int $width = 380, ?int $height = 260): ?string
    {
        if (empty($image)) return null;
        $this->createFolder($path);
        $prepareImage = Image::read($image);
        $prepareImage->cover($width, $height);
        $imageName = $this->generateImageName($image, $path);
        $prepareImage->save(storage_path('app/public/' . $imageName));

        return $imageName;
    }
    private function generateImageName(UploadedFile $image, string $path): string
    {
        return $path . '/' . md5(Carbon::now() . '_' . $image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
    }
    private function createFolder(string $path): void
    {
        if (!Storage::disk(self::STORAGE_DISK)->exists($path)) {
            Storage::disk(self::STORAGE_DISK)->makeDirectory($path);
        }
    }

}
