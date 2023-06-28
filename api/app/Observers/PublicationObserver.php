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
            $publication->user()->associate(Auth::user());
        }
    }
}
