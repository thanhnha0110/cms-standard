<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

interface SettingRepository extends BaseRepository
{
    public function updateOrCreateMany($data);
}