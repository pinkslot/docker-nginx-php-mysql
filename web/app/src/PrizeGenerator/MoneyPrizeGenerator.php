<?php

namespace App\Acme\PrizeGenerator;

use App\Acme\Entity\Prize\MoneyPrize;
use App\Acme\Entity\User;
use App\Acme\RandomGenerator\RandomNumberGeneratorInterface;
use App\Acme\Repository\MoneyDepositRepository\MoneyDepositRepositoryInterface;
use App\Acme\Repository\MoneyPrizeRepository\MoneyPrizeRepositoryInterface;

class MoneyPrizeGenerator implements PrizeGeneratorInterface
{
    private const MIN_VALUE = 1000;
    private const MAX_VALUE = 10000;

    private RandomNumberGeneratorInterface $randomNumberGenerator;

    public function __construct(
        RandomNumberGeneratorInterface $randomNumberGenerator,
        MoneyDepositRepositoryInterface $moneyDepositRepository,
        MoneyPrizeRepositoryInterface $moneyPrizeRepository
    ) {
        $this->randomNumberGenerator = $randomNumberGenerator;
        $this->moneyDepositRepository = $moneyDepositRepository;
        $this->moneyPrizeRepository = $moneyPrizeRepository;
    }

    private function getBalance(): int
    {
        return $this->moneyDepositRepository->getTotalAmount() - $this->moneyPrizeRepository->getTotalAmount();
    }

    public function isAvailable(): bool
    {
        return $this->getBalance() > static::MIN_VALUE;
    }

    public function generatePrize(User $user): MoneyPrize
    {
        $maxValue = min(static::MAX_VALUE, $this->getBalance());

        return new MoneyPrize(
            $user,
            $this->randomNumberGenerator->getNumberInRange(static::MIN_VALUE, $maxValue),
        );
    }
}
