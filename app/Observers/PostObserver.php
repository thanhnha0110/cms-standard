<?php

namespace App\Observers;

use App\Enums\StatusEnum;
use Illuminate\Support\Str;
use App\Models\Post;
use Carbon\Carbon;

class PostObserver
{
    public function creating(Post $item)
    {
        $item->author_id = request()->user()->id;
        $item->slug = Str::slug($item->title, '-');

        if (!$item->published_at && $item->status == StatusEnum::PUBLISHED->value) {
            $item->published_at = Carbon::now()->format('Y-m-d H:i');
        }
    }

    public function updating(Post $item)
    {
        $item->slug = Str::slug($item->title, '-');
        
        if (!$item->published_at && $item->status == StatusEnum::PUBLISHED->value) {
            $item->published_at = Carbon::now()->format('Y-m-d H:i');
        }
    }

    public function deleting(Post $item)
    {
        $item->tags()->sync([]);
    }
}