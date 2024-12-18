<?php

namespace App\Services;

use App\Helpers\Facades\FileHelper;
use Exception;

class MediaFileService extends BaseService
{

    public function __construct()
    {
        
    }


    public function upload($file): array
    {
        if (!$file) {
            throw new Exception(trans('errors.item_not_found'));
        }

        return FileHelper::uploadSingle($file);
    }

    public function destroy($file): ?bool
    {
        if (!$file) {
            throw new Exception(trans('errors.item_not_found'));
        }

        return FileHelper::delete($file->url);
    }
}