<?php

namespace App\Acme\Service;

use App\Acme\Entity\User;
use App\Acme\PrizeGenerator\PrizeGeneratorInterface;
use Doctrine\ORM\EntityManagerInterface;

class PrizeService
{
    private PrizeGeneratorInterface $prizeGenerator;
    private EntityManagerInterface $entityManager;

    public function __construct(PrizeGeneratorInterface $prizeGenerator, EntityManagerInterface $entityManager)
    {
        $this->prizeGenerator = $prizeGenerator;
        $this->entityManager = $entityManager;
    }

    public function generatePrize(User $user): void
    {
        $this->entityManager->wrapInTransaction(
            function () use ($user) {
                $prize = $this->prizeGenerator->generatePrize($user);
                $this->entityManager->persist($prize);

                return $prize;
            }
        );
    }
}
