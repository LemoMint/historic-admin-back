<?php

namespace App\Services;

use App\Models\Bookmark;
use App\Http\Requests\Bookmarks\BookmarkCreateDto;

class BookmarkService
{
    public function store(BookmarkCreateDto $dto): Bookmark
    {
        $bookmark = new Bookmark($dto->safe()->all());

        $bookmark->save();

        return $bookmark;
    }
}
