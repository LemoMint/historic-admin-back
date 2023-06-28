<?php

namespace App\Observers;

use App\Models\User;
use App\Models\PublishingHouse;
use Illuminate\Support\Facades\Auth;

class PublishingHouseObserver
{
    public function creating(PublishingHouse $publishingHouse)
    {
        if (!$publishingHouse->user) {
            $publishingHouse->user()->associate(Auth::user());
        }
    }
}
