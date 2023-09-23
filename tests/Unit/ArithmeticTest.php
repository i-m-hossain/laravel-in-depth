<?php

namespace Tests\Unit;

use App\Helpers\Math\ArithmeticHelper;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ArithmeticTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_add_can_sum_numbers_up(): void
    {
        $num1=11;
        $num2=19;
        $sum = $num1+$num2;
        $result = ArithmeticHelper::add($num1, $num2);
        $this->assertSame($sum, $result, 'Does not add numbers correctly');

    }
    public function test_add_can_take_in_multiple_numbers():void
    {
        $num1=11;
        $num2=19;
        $num3 = 23;
        $sum = $num1+$num2+$num3;
        $result = ArithmeticHelper::add($num1, $num2, $num3);
        $this->assertSame($sum, $result, 'Does not add numbers correctly');

    }
    public function test_add_can_not_take_in_string_arguments():void
    {
        $this->expectException(InvalidArgumentException::class);
        ArithmeticHelper::add('abc');
    }
    public function test_add_can_not_take_in_null_arguments():void
    {
        $this->expectException(InvalidArgumentException::class);
        ArithmeticHelper::add(null);

    }
    public function test_add_can_not_take_in_function_arguments():void
    {
        $this->expectException(InvalidArgumentException::class);
        ArithmeticHelper::add(fn()=>true);
    }
    public function test_add_can_not_take_in_array_arguments():void
    {
        $this->expectException(InvalidArgumentException::class);
        ArithmeticHelper::add(['abc']);
    }
    public function test_add_can_not_take_in_boolean_arguments():void
    {
        $this->expectException(InvalidArgumentException::class);
        ArithmeticHelper::add(true);
    }
    public function test_add_needs_at_least_one_argument():void
    {
        $this->expectException(InvalidArgumentException::class);
        ArithmeticHelper::add();
    }
}
