<?php

namespace App\Acme\Repository\MoneyPrizeRepository;

use Doctrine\ORM\EntityRepository;

class MoneyPrizeRepository extends EntityRepository implements MoneyPrizeRepositoryInterface
{
    public function getTotalAmount(): int
    {
        $qb = $this->createQueryBuilder('moneyPrize');
        $qb->select('SUM(moneyPrize.amount)');

        return $qb->getQuery()->getSingleScalarResult() ?? 0;
    }
}
