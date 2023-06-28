<?php

namespace App\Services\Recognition\Drivers;

use App\Models\Document;
use App\Helpers\FileStorageHelper;

class AbstractDriver
{
    protected static function getFilePath(Document $document): ?string
    {
        return FileStorageHelper::getFilePath($document) ?? null;
    }
}
