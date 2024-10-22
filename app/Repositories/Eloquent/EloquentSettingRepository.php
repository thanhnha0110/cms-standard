<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Repositories\SettingRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class EloquentSettingRepository extends EloquentBaseRepository implements SettingRepository
{
    /**
     * 
     * @param array $data
     */
    public function updateOrCreateMany($data)
    {
        foreach ($data as $key => $value) {
            $this->model->updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}