<?php

namespace App\Enums;

enum LogActionEnum: string
{
    case CREATED = 'created';
    case UPDATED = 'updated';
    case DELETED = 'deleted';

    public static function toArray(): array
    {
        return [
            self::CREATED->value => 'Created',
            self::UPDATED->value => 'Updated',
            self::DELETED->value => 'Deleted',
        ];
    }
}