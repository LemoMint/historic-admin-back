<?php

namespace App\Helpers;

use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileHelper
{
    public static function saveFile(UploadedFile $file, string $disk): ?string
    {
        $filePath = self::generateFilePath($file);

        if (!Storage::disk($disk)->put($filePath, file_get_contents($file))) {
            $filePath = null;
        }

        return $filePath;
    }

    public static function generateFilePath(UploadedFile $file): string
    {
        return pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME).'.'.$file->extension();
    }

    public static function generateFilePathByName(string $fileName, string $disk): string
    {
        return Storage::disk($disk)->path($fileName);
    }

    public static function deleteFile(string $fileName, string $disk): void
    {
        Storage::disk($disk)->delete($fileName);
    }
}
