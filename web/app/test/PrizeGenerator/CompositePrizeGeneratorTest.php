<?php

namespace AppTest\Acme\PrizeGenerator;

use App\Acme\Entity\Prize\MoneyPrize;
use App\Acme\Entity\User;
use App\Acme\PrizeGenerator\CompositePrizeGenerator;
use App\Acme\PrizeGenerator\PrizeGeneratorInterface;
use App\Acme\RandomGenerator\RandomArrayElementGeneratorInterface;
use PHPUnit\Framework\TestCase;

class CompositePrizeGeneratorTest extends TestCase
{
    public function testGenerate()
    {
        $user = new User('test', 'test');

        $prizeGeneratorBuilder = $this->getMockBuilder(PrizeGeneratorInterface::class);
        $prizeGenerator1 = $prizeGeneratorBuilder->getMock();
        $prizeGenerator1->method('isAvailable')->willReturn(true);
        $prizeGenerator1->expects($this->never())->method('generatePrize')
            ->willReturn(new MoneyPrize($user, 111))
        ;

        $prizeGenerator2 = $prizeGeneratorBuilder->getMock();
        $prizeGenerator2->method('isAvailable')->willReturn(false);
        $prizeGenerator2->expects($this->never())->method('generatePrize')
            ->willReturn(new MoneyPrize($user, 222))
        ;

        $prizeGenerator3 = $prizeGeneratorBuilder->getMock();
        $prizeGenerator3->method('isAvailable')->willReturn(true);
        $prizeGenerator3->expects($this->once())->method('generatePrize')
            ->willReturn(new MoneyPrize($user, 333))
        ;

        $randomGenerator = $this->getMockBuilder(RandomArrayElementGeneratorInterface::class)->getMock();
        $randomGenerator->method('getRandomElement')
            ->willReturnCallback(fn ($array) => $array[1])
        ;

        $compositeGenerator = new CompositePrizeGenerator([
            $prizeGenerator1,
            $prizeGenerator2,
            $prizeGenerator3,
        ], $randomGenerator);

        /** @var MoneyPrize $result */
        $result = $compositeGenerator->generatePrize($user);
        $this->assertEquals(333, $result->getAmount());
    }
}
