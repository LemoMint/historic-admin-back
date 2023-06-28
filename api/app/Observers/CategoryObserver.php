<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryObserver
{
    public function creating(Category $category)
    {
        if (!$category->user_id) {
            $category->user()->associate(Auth::user());
        }
    }
}
