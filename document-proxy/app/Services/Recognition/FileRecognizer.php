<?php

namespace App\Services\Recognition;

use App\Models\Document;
use App\Services\Recognition\Drivers\Local;
use App\Services\Recognition\Drivers\Yandex;

class FileRecognizer
{
    public function __construct(private Local $localDriver) {}

    public function convertToText(Document $document)
    {
        $extension = $document->extension;
        $driver = config('recognition.'.$extension.'.driver')."Driver";
        $handlerClass = $extension."Handler";
        $this->$driver->$handlerClass::toText($document, $this->$driver);
    }
}
