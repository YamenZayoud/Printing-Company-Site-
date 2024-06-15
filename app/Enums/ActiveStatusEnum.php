<?php

namespace App\Enums;

class ActiveStatusEnum
{

    const ACTIVE = true;
    const INACTIVE = false;

    public static function toArray(){
        return [
            self::ACTIVE,
            self::INACTIVE,
        ];
    }


}
