<?php

namespace App\Acme\Repository\MoneyPrizeRepository;

interface MoneyPrizeRepositoryInterface
{
    public function getTotalAmount(): int;
}
