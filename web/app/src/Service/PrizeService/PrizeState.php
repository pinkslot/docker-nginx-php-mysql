<?php

namespace App\Acme\Service\PrizeService;

class PrizeState
{
    public int $moneyAmount;
    public int $bonusesAmount;
    public int $moneyBalance;

    public function __construct(int $moneyAmount, int $bonusesAmount, int $moneyBalance)
    {
        $this->moneyAmount = $moneyAmount;
        $this->bonusesAmount = $bonusesAmount;
        $this->moneyBalance = $moneyBalance;
    }
}
