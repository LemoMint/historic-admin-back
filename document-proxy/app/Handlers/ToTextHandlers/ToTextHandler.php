<?php

namespace App\Handlers\ToTextHandlers;

use App\Models\Document;
use App\Services\Recognition\Drivers\Local;
use App\Services\Recognition\Drivers\Yandex;

class ToTextHandler
{
    public function __construct(private Local $localDriver, private Yandex $yandexDriver) {}

    public function toText(Document $document)
    {
        $extension = $document->extension;

        $topic =  $document->isImageTopic() ? "images" : $extension;
        $driver = config('recognition.'.$topic.'.driver')."Driver";
        $method = $topic.'Handle';

        return $this->$driver->$method($document);
    }
}
