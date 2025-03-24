<?php

namespace App\Repositories\Eloquent;

use App\Enums\UserStatusEnum;
use App\Models\Comment;
use App\Repositories\CommentRepository;
use App\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class EloquentCommentRepository extends EloquentBaseRepository implements CommentRepository
{
    /**
     * Paginating, ordering and searching through pages for server side index table
     * @param Request $request
     */
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $search = $request->search;
        return $this->model->whereNull('parent_id')->when($search, function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->orderBy('id', 'desc')->paginate($request->size ?? 10);
    }


    public function reply(Comment $comment, Request $request)
    {
        $comment->update([
            'is_replied' => true,
        ]);
        return $this->model->create([
            'post_id' => $comment->post_id,
            'user_id' => $request->user()->id,
            'parent_id' => $comment->id,
            'content' => $request->content,
            'status' => UserStatusEnum::ACTIVE,
            'is_replied' => false,
        ]);
    }
}