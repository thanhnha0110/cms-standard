<?php

namespace App\Enums;

enum SiteLanguageEnum: string
{
    case EN = 'en';

    public static function toArray(): array
    {
        return [
            self::EN->value => 'English',
        ];
    }
}