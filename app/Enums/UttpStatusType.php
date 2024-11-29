<?php

namespace App\Enums;

enum UttpStatusType: string
{
    case SAH = 'sah';
    case BATAL = 'batal';
    case NEAR_EXPIRATION = 'near_expiration';
    case EXPIRED = 'expired';

    public function label(): string
    {
        return match($this) {
            self::SAH => 'Sah',
            self::BATAL => 'Batal',
            self::NEAR_EXPIRATION => 'Akan Habis',
            self::EXPIRED => 'Sudah Habis',
        };
    }
}
