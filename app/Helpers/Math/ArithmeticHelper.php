<?php
namespace App\Helpers\Math;

use InvalidArgumentException;

class ArithmeticHelper{
    public static function add(...$numbers){
        if(sizeof($numbers)<1){
            throw new InvalidArgumentException('Must have at least one argument');
        }
        $sum=0;
        foreach ($numbers as $num) {
            if(!(is_float($num)|| is_int($num))){
                throw new InvalidArgumentException('Argument can only be numeric');
            }
            $sum += $num;
        }
        return $sum;
    }

}
