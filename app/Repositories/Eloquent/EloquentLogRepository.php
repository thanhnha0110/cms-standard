<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Repositories\LogRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class EloquentLogRepository extends EloquentBaseRepository implements LogRepository
{
    /**
     * Paginating, ordering and searching through pages for server side index table
     * @param Request $request
     */
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $search = $request->search;
        return $this->model->when($search, function ($query) use ($search) {
            return $query->whereHas('causedBy', function ($q) use ($search) {
                $q->where('first_name', 'like', '%' . $search . '%');
                $q->orWhere('last_name', 'like', '%' . $search . '%');
            })
            ->orWhere('action', 'like', '%' . $search . '%')
            ->orWhere('module', 'like', '%' . $search . '%');
        })->orderBy('id', 'desc')->paginate($request->size ?? 10);
    }
}