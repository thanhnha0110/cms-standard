<?php

namespace App\Observers;

use App\Models\Tag;
use Illuminate\Support\Str;

class TagObserver
{
    public function creating(Tag $item)
    {
        $item->slug = Str::slug($item->name, '-');
    }
}