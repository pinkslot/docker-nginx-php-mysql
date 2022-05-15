<?php

namespace App\Acme\Service\PrizeService;

use App\Acme\Entity\User;
use App\Acme\PrizeGenerator\PrizeGeneratorInterface;
use App\Acme\Repository\BonusesPrizeRepository\BonusesPrizeRepository;
use App\Acme\Repository\MoneyDepositRepository\MoneyDepositRepositoryInterface;
use App\Acme\Repository\MoneyPrizeRepository\MoneyPrizeRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class PrizeService
{
    private PrizeGeneratorInterface $prizeGenerator;
    private EntityManagerInterface $entityManager;
    private MoneyDepositRepositoryInterface $moneyDepositRepository;
    private MoneyPrizeRepositoryInterface $moneyPrizeRepository;
    private BonusesPrizeRepository $bonusesPrizeRepository;

    public function __construct(
        PrizeGeneratorInterface $prizeGenerator,
        EntityManagerInterface $entityManager,
        MoneyDepositRepositoryInterface $moneyDepositRepository,
        MoneyPrizeRepositoryInterface $moneyPrizeRepository,
        BonusesPrizeRepository $bonusesPrizeRepository
    ) {
        $this->prizeGenerator = $prizeGenerator;
        $this->entityManager = $entityManager;
        $this->moneyDepositRepository = $moneyDepositRepository;
        $this->moneyPrizeRepository = $moneyPrizeRepository;
        $this->bonusesPrizeRepository = $bonusesPrizeRepository;
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

    public function getState(User $user): PrizeState
    {
        return new PrizeState(
            $this->moneyPrizeRepository->getUserTotalAmount($user),
            $this->bonusesPrizeRepository->getUserTotalAmount($user),
            $this->moneyDepositRepository->getTotalAmount() - $this->moneyPrizeRepository->getTotalAmount(),
        );
    }
}
