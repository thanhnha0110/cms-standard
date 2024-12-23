<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface TagRepository extends BaseRepository
{
    /**
     * Paginating, ordering and searching through pages for server side index table
     * @param Request $request
     */
    public function serverPaginationFilteringFor(Request $request);

    /**
     * Save tags with post
     *
     * @param object|Post $post
     * @param array|Collection $tags
     * @return void
     */
    public function saveWithPost(Post $post, array|Collection $tags);
}