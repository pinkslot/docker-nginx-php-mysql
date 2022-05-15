<?php

namespace App\Acme\Repository\MoneyDepositRepository;

use Doctrine\ORM\EntityRepository;

class MoneyDepositRepository extends EntityRepository implements MoneyDepositRepositoryInterface
{
    public function getTotalAmount(): int
    {
        $qb = $this->createQueryBuilder('moneyDeposit');
        $qb->select('SUM(moneyDeposit.amount)');

        return $qb->getQuery()->getSingleScalarResult() ?? 0;
    }
}
