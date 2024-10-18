<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface LogRepository extends BaseRepository
{
    /**
     * Paginating, ordering and searching through pages for server side index table
     * @param Request $request
     */
    public function serverPaginationFilteringFor(Request $request);
}