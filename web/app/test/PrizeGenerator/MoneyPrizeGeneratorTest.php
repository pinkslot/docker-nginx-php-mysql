<?php

namespace AppTest\Acme\PrizeGenerator;

use App\Acme\Entity\User;
use App\Acme\PrizeGenerator\MoneyPrizeGenerator;
use App\Acme\RandomGenerator\RandomNumberGeneratorInterface;
use App\Acme\Repository\MoneyDepositRepository\MoneyDepositRepositoryInterface;
use App\Acme\Repository\MoneyPrizeRepository\MoneyPrizeRepositoryInterface;
use PHPUnit\Framework\TestCase;

class MoneyPrizeGeneratorTest extends TestCase
{
    /** @dataProvider cases */
    public function testGenerate(
        array $randomInRange,
        int $totalPrize,
        int $totalDeposit,
        bool $isAvailable,
        int $prizeAmount
    ) {
        $user = new User('test', 'test');

        $randomGenerator = $this->getMockBuilder(RandomNumberGeneratorInterface::class)->getMock();
        $randomGenerator->method('getNumberInRange')
            ->with(...$randomInRange)
            ->willReturn($prizeAmount)
        ;
        $moneyPrizeRepository = $this->getMockBuilder(MoneyPrizeRepositoryInterface::class)->getMock();
        $moneyPrizeRepository->method('getTotalAmount')->willReturn($totalPrize);
        $moneyDepositRepository = $this->getMockBuilder(MoneyDepositRepositoryInterface::class)->getMock();
        $moneyDepositRepository->method('getTotalAmount')->willReturn($totalDeposit);

        $moneyPrizeGenerator = new MoneyPrizeGenerator($randomGenerator, $moneyDepositRepository, $moneyPrizeRepository);

        $this->assertEquals($isAvailable, $moneyPrizeGenerator->isAvailable());

        if ($isAvailable) {
            $prize = $moneyPrizeGenerator->generatePrize($user);
            $this->assertEquals($prizeAmount, $prize->getAmount());
        }
    }

    public function cases(): array
    {
        return [
            'enough_deposit_for_max_prize' => [[1000, 10000], 3000, 15000, true, 8000],
            'deposit_less_then_max_prize' => [[1000, 8000], 7000, 15000, true, 5000],
            'deposit_less_then_min_prize' => [[0, 0], 14500, 15000, false, 0],
        ];
    }
}
