<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Author;
use Illuminate\Support\Facades\Auth;

class AuthorObserver
{
    public function creating(Author $author)
    {
        if (!$author->user) {
            $author->user()->associate(Auth::user());
        }

        if (!$author->patronymic_name) {
            $author->patronymic_name = "";
        }
    }
}
