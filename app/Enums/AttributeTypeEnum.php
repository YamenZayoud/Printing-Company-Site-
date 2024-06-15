<?php

namespace App\Enums;

class AttributeTypeEnum
{

    const TextInput = 0;
    const DropDown = 1;
    const CheckBox = 2;

    public static function toArray(){
        return [
            self::TextInput,
            self::DropDown,
            self::CheckBox,
        ];
    }


}
