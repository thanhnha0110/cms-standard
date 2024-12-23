<?php

namespace App\Enums;

enum StatusEnum: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case SCHEDULED = 'scheduled';

    public static function toArray(): array
    {
        return [
            self::DRAFT->value => 'Draft',
            self::PUBLISHED->value => 'Published',
            self::SCHEDULED->value => 'Scheduled',
        ];
    }

    public function getClass(): string
    {
        return match ($this) {
            self::DRAFT => 'm-badge--warning',
            self::PUBLISHED => 'm-badge--success',
            self::SCHEDULED => 'm-badge--focus',
            default => 'm-badge--default',
        };
    }

    public function getText(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::PUBLISHED => 'Published',
            self::SCHEDULED => 'Scheduled',
            default => 'Unknown',
        };
    }
}