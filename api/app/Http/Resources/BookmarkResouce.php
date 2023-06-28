<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookmarkResouce extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'page' => $this->page
        ];
    }
}
