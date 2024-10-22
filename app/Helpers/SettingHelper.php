<?php

namespace App\Helpers;

/**
 * Class Setting.
 */
class SettingHelper
{

    public function __construct()
    {
        //
    }

    /**
     * Prepare insert data
     *
     * @return array
     */
    public function prepareInsertData(array $data): array
    {
        unset($data['_token']);
        return $data;
        // $dbData = [];

        // foreach ($data as $key => $value) {
        //     $data = compact('key', 'value');
        //     $dbData[] = $data;
        // }
        // return $dbData;
    }

}