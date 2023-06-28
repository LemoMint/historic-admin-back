<?php

namespace App\Helpers;

use App\Models\Document;
use App\Models\Publication;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PhpParser\Comment\Doc;

class FileStorageHelper
{
    public static function getFilePath(Document $document): ?string
    {
        return Storage::disk($document->disk)->path($document->extension.'/'.pathinfo($document->file_name, PATHINFO_FILENAME).'/origin.'.$document->extension);
    }

    public static function getFile($disk, $path): ?string
    {
        return Storage::disk($disk)->get($path);
    }

    public static function getBase64File(Document $document): ?string
    {
        return base64_encode(file_get_contents(self::getFilePath($document)));
    }

    public static function setToTextFile(Document $document, string $text): void
    {
        Storage::disk($document->disk)->put($document->extension.'/'.pathinfo($document->file_name, PATHINFO_FILENAME).'/text.txt', $text, 'public');
    }
}
