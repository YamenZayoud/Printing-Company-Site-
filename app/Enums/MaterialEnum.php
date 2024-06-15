<?php

namespace App\Enums;

class MaterialEnum
{

    const input = 1;
    const output = 0;

    public static function toArray()
    {
        return [
            self::input,
            self::output,
        ];
    }
}