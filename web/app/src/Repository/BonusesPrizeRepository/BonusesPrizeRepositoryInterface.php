<?php

namespace App\Acme\Repository\BonusesPrizeRepository;

use App\Acme\Entity\User;

interface BonusesPrizeRepositoryInterface
{
    public function getUserTotalAmount(User $user): int;
}
