<?php

namespace App\Enums;

class PriceTypeEnum
{

    const FlatPrice = 0 ;
    const FormulaPrice = 1 ;

    public static function toArray(){
        return [
            self::FlatPrice,
            self::FormulaPrice,
        ];
    }


}
