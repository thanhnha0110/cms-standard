<?php

namespace App\Enums;

enum MailerEnum: string
{
    case SMTP = 'smtp';
    case SES = 'ses';

    public static function toArray(): array
    {
        return [
            self::SMTP->value => 'SMTP',
            self::SES->value => 'SES',
        ];
    }
}