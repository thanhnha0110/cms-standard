<?php

namespace App\Enums;

enum UserStatusEnum: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case CANCELED = 'canceled';

    public static function toArray(): array
    {
        return [
            self::ACTIVE->value => 'Active',
            self::INACTIVE->value => 'Inactive',
            self::CANCELED->value => 'Canceled',
        ];
    }

    public function getClass(): string
    {
        return match ($this) {
            self::ACTIVE => 'm-badge--success',
            self::INACTIVE => 'm-badge--warning',
            self::CANCELED => 'm-badge--danger',
            default => 'm-badge--default',
        };
    }

    public function getText(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
            self::CANCELED => 'Canceled',
            default => 'Unknown',
        };
    }
}