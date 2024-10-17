<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

interface PermissionRepository extends BaseRepository
{
    /**
     * Paginating, ordering and searching through pages for server side index table
     * @param Request $request
     */
    public function serverPaginationFilteringFor(Request $request);

    /**
     * Paginating, ordering and searching through pages for server side index table
     * @param Request $request
     */
    public function createManyByRole($role, array $permissions);
}