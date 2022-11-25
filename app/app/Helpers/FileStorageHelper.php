<?php

namespace App\Helpers;

use App\Models\Document;
use App\Models\Publication;
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

        if (Storage::disk(Document::DEFAULT_DISK)->put($extension.'/'.$fileName, file_get_contents($file))) {
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
}
