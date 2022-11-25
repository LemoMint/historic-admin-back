<?php

namespace App\Observers;

use App\Models\Document;
use Illuminate\Support\Str;

class DocumentUUIDObserver
{
    public function creating(Document $document)
    {
        $document->uuid = Str::uuid();
    }
}
