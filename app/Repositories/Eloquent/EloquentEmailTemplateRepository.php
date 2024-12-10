<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Repositories\EmailTemplateRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class EloquentEmailTemplateRepository extends EloquentBaseRepository implements EmailTemplateRepository
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
}