<?php

namespace App\Helpers;

use App\Models\Document;
use App\Models\Publication;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileStorageHelper
{
    /**
     * @param UploadedFile $file
     * @param string $disk
     * @param string $path
     */
    public static function saveFile(UploadedFile $file, $path = '/'): Document|null
    {
        $document = null;
        $fileName = $file->getClientOriginalName();
        $extension = $file->extension();

        if (!Storage::disk(Document::DEFAULT_DISK)->exists($extension)) {
            Storage::disk(Document::DEFAULT_DISK)->makeDirectory($extension, 'public');
        }

        if (Storage::disk(Document::DEFAULT_DISK)->put($extension.'/'.pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME).'/origin.'.$extension, file_get_contents($file), 'public')) {
            $document = new Document();

            $document->file_name = $fileName;
            $document->disk = Document::DEFAULT_DISK;
            $document->extension = $extension;

            $document->save();
        }

        return $document;
    }

    public static function deleteFile(Document $document): void
    {
        Storage::disk(Document::DEFAULT_DISK)->delete($document->extension.'/'.$document->file_name);
    }

    public static function getFilePath(Document $document, bool $origin = true): ?string
    {
        $extenstionReal = $origin ? $document->extension : "txt";
        $fileNameReal = $origin ? '/origin.' : '/text.';

        if (!Storage::disk($document->disk)->exists($document->extension.'/'.pathinfo($document->file_name, PATHINFO_FILENAME). $fileNameReal . $extenstionReal)) {
            return null;
        }

        return Storage::disk($document->disk)->path($document->extension.'/'.pathinfo($document->file_name, PATHINFO_FILENAME). $fileNameReal . $extenstionReal);
    }
}
