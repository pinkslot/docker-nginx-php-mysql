<?php

namespace App\Acme\Repository\MoneyPrizeRepository;

use App\Acme\Entity\User;

interface MoneyPrizeRepositoryInterface
{
    public function getTotalAmount(): int;
    public function getUserTotalAmount(User $user): int;
}
