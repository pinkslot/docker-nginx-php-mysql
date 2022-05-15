<?php

namespace App\Acme\RandomGenerator;

interface RandomArrayElementGeneratorInterface
{
    public function getRandomElement(array $array);
}
