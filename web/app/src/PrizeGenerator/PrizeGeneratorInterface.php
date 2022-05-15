<?php

namespace App\Acme\PrizeGenerator;

use App\Acme\Entity\Prize\PrizeInterface;
use App\Acme\Entity\User;

interface PrizeGeneratorInterface
{
    public function isAvailable(): bool;

    public function generatePrize(User $user): PrizeInterface;
}
