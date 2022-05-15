<?php

namespace App\Acme\PrizeGenerator;

use App\Acme\Entity\Prize\BonusesPrize;
use App\Acme\Entity\User;
use App\Acme\RandomGenerator\RandomNumberGeneratorInterface;

class BonusesPrizeGenerator implements PrizeGeneratorInterface
{
    private const MIN_VALUE = 1000;
    private const MAX_VALUE = 10000;

    private RandomNumberGeneratorInterface $randomNumberGenerator;

    public function __construct(RandomNumberGeneratorInterface $randomNumberGenerator)
    {
        $this->randomNumberGenerator = $randomNumberGenerator;
    }

    public function isAvailable(): bool
    {
        return true;
    }

    public function generatePrize(User $user): BonusesPrize
    {
        return new BonusesPrize(
            $user,
            $this->randomNumberGenerator->getNumberInRange(static::MIN_VALUE, static::MAX_VALUE),
        );
    }
}
