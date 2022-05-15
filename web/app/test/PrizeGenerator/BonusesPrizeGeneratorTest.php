<?php

namespace AppTest\Acme\PrizeGenerator;

use App\Acme\Entity\Prize\BonusesPrize;
use App\Acme\Entity\User;
use App\Acme\PrizeGenerator\BonusesPrizeGenerator;
use App\Acme\RandomGenerator\RandomNumberGeneratorInterface;
use PHPUnit\Framework\TestCase;

class BonusesPrizeGeneratorTest extends TestCase
{
    public function testGenerate() {
        $user = new User('test', 'test');

        $randomGenerator = $this->getMockBuilder(RandomNumberGeneratorInterface::class)->getMock();
        $randomGenerator->method('getNumberInRange')
            ->with(1000, 10000)
            ->willReturn(5000)
        ;
        $moneyPrizeGenerator = new BonusesPrizeGenerator($randomGenerator);

        $this->assertEquals(true, $moneyPrizeGenerator->isAvailable());
        /** @var BonusesPrize $prize */
        $prize = $moneyPrizeGenerator->generatePrize($user);
        $this->assertEquals(5000, $prize->getAmount());
    }
}
