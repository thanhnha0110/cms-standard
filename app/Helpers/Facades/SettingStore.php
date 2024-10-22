<?php

namespace App\Helpers\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array prepareInsertData(array $data)
 *
 * @see App\Helpers\SettingHelper
 */

class SettingStore extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'setting';
    }
}