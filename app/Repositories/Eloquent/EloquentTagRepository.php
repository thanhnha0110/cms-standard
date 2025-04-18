<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Repositories\TagRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class EloquentTagRepository extends EloquentBaseRepository implements TagRepository
{
    /**
     * Paginating, ordering and searching through pages for server side index table
     * @param Request $request
     */
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $search = $request->search;
        return $this->model->when($search, function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->orderBy('id', 'desc')->paginate($request->size ?? 10);
    }


    public function saveWithPost($post, $tags)
    {
        if (!is_array($tags)) {
            $tags = json_decode($tags);
        }

        $tags = collect($tags)->map(function ($tag) {
            return $this->model->firstOrCreate(['name' => $tag->value]);
        });

        $post->tags()->sync($tags->pluck('id'));
    }
}