<?php

namespace App\Observers;

use App\Models\PublishingHouse;
use Illuminate\Support\Facades\Auth;

class PublishingHouseObserver
{
    public function creating(PublishingHouse $publishingHouse)
    {
        if (!$publishingHouse->user) {
            Auth::login(User::first());

            $publishingHouse->user()->associate(Auth::user());
        }
    }
}
