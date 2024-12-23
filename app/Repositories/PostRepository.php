<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface PostRepository extends BaseRepository
{
    /**
     * Paginating, ordering and searching through pages for server side index table
     * @param Request $request
     */
    public function serverPaginationFilteringFor(Request $request);
}