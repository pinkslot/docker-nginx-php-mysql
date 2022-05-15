<?php

namespace App\Acme\Repository\MoneyPrizeRepository;

use App\Acme\Entity\User;
use Doctrine\ORM\EntityRepository;
use function Doctrine\ORM\QueryBuilder;

class MoneyPrizeRepository extends EntityRepository implements MoneyPrizeRepositoryInterface
{
    public function getTotalAmount(): int
    {
        $qb = $this->createQueryBuilder('moneyPrize');
        $qb->select('SUM(moneyPrize.amount)');

        return $qb->getQuery()->getSingleScalarResult() ?? 0;
    }

    public function getUserTotalAmount(User $user): int
    {
        $qb = $this->createQueryBuilder('moneyPrize');
        $qb
            ->select('SUM(moneyPrize.amount)')
            ->join('moneyPrize.user', 'user')
            ->andWhere($qb->expr()->eq('user.id', $user->getId()))
        ;

        return $qb->getQuery()->getSingleScalarResult() ?? 0;
    }
}
