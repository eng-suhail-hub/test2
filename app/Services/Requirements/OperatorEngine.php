<?php

namespace App\Services\Requirements;

class OperatorEngine
{
    public function evaluate($operator, $actual, $expected): bool
    {
        return match ($operator) {
            '>=' => $actual >= $expected,
            '<=' => $actual <= $expected,
            '='  => $actual == $expected,
            '!=' => $actual != $expected,
            'IN' => in_array($actual, $expected),
            'BETWEEN' => $actual >= $expected[0] && $actual <= $expected[1],
        };
    }
}
