<?php

namespace Some\Name;

use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    /** @test
     * @dataProvider threeNumbers */
    public function returnsTheSum($a, $b, $c, $expected)
    {
        self::assertSame($expected, array_sum([$a, $b, $c]));
    }

    public function threeNumbers()
    {
        return [
            '1+2+3' => [1, 2, 3, 6],
            'anything' => [3, 4, 5, 12],
            'named' => [0, 0, 0, 0],
        ];
    }

    /** @test
     * @dataProvider twoNumbers */
    public function returnsThePower($a, $b, $expected)
    {
        self::assertSame($expected, pow($a, $b));
        return [
            [3, 2, 9],
            [2, 3, 8],
        ];
    }

    public function twoNumbers()
    {
        return [
            [3, 2, 9],
            [2, 3, 8],
        ];
    }
}
