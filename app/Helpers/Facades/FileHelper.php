<?php

namespace App\Helpers\Facades;

use Illuminate\Support\Facades\Facade;


/**
 * @method static string|null getName(\Illuminate\Http\UploadedFile $file)
 * @method static string|null getAlt(\Illuminate\Http\UploadedFile $file)
 * @method static string|null getMineType(\Illuminate\Http\UploadedFile $file)
 * @method static int getSize(\Illuminate\Http\UploadedFile $file)
 * @method static array uploadSingle(\Illuminate\Http\UploadedFile $file)
 * @method static bool|null delete(string $path)
 * @method static string formatBytes(int $bytes, int|null $precision)
 *
 * @see App\Helpers\SettingHelper
 */

class FileHelper extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'file';
    }
}