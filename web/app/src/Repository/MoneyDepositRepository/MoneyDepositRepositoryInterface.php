<?php

namespace App\Acme\Repository\MoneyDepositRepository;

interface MoneyDepositRepositoryInterface
{
    public function getTotalAmount(): int;
}
