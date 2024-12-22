<?php

namespace App\Observers;

use App\Models\Setting;

class SettingObserver
{
    public function updating(Setting $item)
    {
        clear_cache($item->key);
    }
}