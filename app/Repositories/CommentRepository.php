<?php

namespace App\Repositories;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

interface CommentRepository extends BaseRepository
{
    /**
     * Paginating, ordering and searching through pages for server side index table
     * @param Request $request
     */
    public function serverPaginationFilteringFor(Request $request);
    public function reply(Comment $comment, Request $request);
}