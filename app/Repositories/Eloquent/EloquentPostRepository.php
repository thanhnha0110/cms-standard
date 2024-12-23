<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Repositories\PostRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class EloquentPostRepository extends EloquentBaseRepository implements PostRepository
{
    /**
     * Paginating, ordering and searching through pages for server side index table
     * @param Request $request
     */
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $search = $request->search;
        $categoryId = $request->category_id;
        $tagId = $request->tag_id;
        return $this->model->when($search, function ($query) use ($search) {
            return $query->where('title', 'like', '%' . $search . '%');
        })
        ->when($categoryId, function ($query) use ($categoryId) {
            return $query->where('category_id', $categoryId);
        })
        ->when($tagId, function ($query) use ($tagId) {
            return $query->whereHas('tags', function ($q) use ($tagId) {
                $q->where('id', $tagId);
            });
        })
        ->orderBy('id', 'desc')->paginate($request->size ?? 10);
    }
}