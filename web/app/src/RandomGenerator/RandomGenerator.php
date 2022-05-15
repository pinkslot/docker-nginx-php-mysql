<?php

namespace App\Acme\RandomGenerator;

class RandomGenerator implements RandomNumberGeneratorInterface, RandomArrayElementGeneratorInterface
{
    public function getNumberInRange(int $min, int $max): int
    {
        return rand($min, $max);
    }

    public function getRandomElement(array $array)
    {
        $key = array_rand($array);

        return $array[$key];
    }
}
