<?php

namespace App\Acme\PrizeGenerator;

use App\Acme\Entity\Prize\PrizeInterface;
use App\Acme\Entity\User;
use App\Acme\RandomGenerator\RandomArrayElementGeneratorInterface;
use Exception;

class CompositePrizeGenerator implements PrizeGeneratorInterface
{
    /**
     * @var PrizeGeneratorInterface[]
     */
    private array $generators;

    private RandomArrayElementGeneratorInterface $randomArrayElementGenerator;

    /** @param PrizeGeneratorInterface[] $generators */
    public function __construct(array $generators, RandomArrayElementGeneratorInterface $randomArrayElementGenerator)
    {
        $this->generators = $generators;
        $this->randomArrayElementGenerator = $randomArrayElementGenerator;
    }

    public function isAvailable(): bool
    {
        return true;
    }

    public function generatePrize(User $user): PrizeInterface
    {
        $availableGenerators = array_filter($this->generators, fn ($gen) => $gen->isAvailable());
        if (count($availableGenerators) === 0) {
            throw new Exception('No available prize generators');
        }

        /** @var PrizeGeneratorInterface $generator */
        $generator = $this->randomArrayElementGenerator->getRandomElement(array_values($availableGenerators));

        return $generator->generatePrize($user);
    }
}
