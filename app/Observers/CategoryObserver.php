<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    public function creating(Category $item)
    {
        clear_cache('categories');
    }

    public function updating(Category $item)
    {
        clear_cache('categories');
    }

    public function deleting(Category $item)
    {
        clear_cache('categories');
    }
}