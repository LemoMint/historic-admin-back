<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Publication;
use Illuminate\Support\Facades\Auth;

class PublicationObserver
{
    public function creating(Publication $publication)
    {
        if (!$publication->user) {
            Auth::login(User::first());

            $publication->user()->associate(Auth::user());
        }
    }
}
