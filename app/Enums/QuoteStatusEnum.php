<?php

namespace App\Enums;

class QuoteStatusEnum
{

    const Pending = 0;
    const Accepted = 1;
    const Rejected = 2;
    const Replied = 3;
    const Canceled = 4;

    public static function toArray()
    {
        return [
            self::Pending,
            self::Accepted,
            self::Rejected,
            self::Replied,
            self::Canceled,
        ];


    }

    public static function ChangeStatus()
    {
        return [
            self::Accepted,
            self::Rejected,
        ];


    }
}
