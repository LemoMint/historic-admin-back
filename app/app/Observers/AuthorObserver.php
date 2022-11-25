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
            Auth::login(User::first());

            $author->user()->associate(Auth::user());
        }
    }
}
