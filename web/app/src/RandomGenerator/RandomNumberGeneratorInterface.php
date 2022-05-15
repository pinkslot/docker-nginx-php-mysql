<?php

namespace App\Acme\RandomGenerator;

interface RandomNumberGeneratorInterface
{
    public function getNumberInRange(int $min, int $max): int;
}
