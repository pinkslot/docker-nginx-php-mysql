<?php

namespace App\Acme\Repository\BonusesPrizeRepository;

use App\Acme\Entity\User;
use Doctrine\ORM\EntityRepository;

class BonusesPrizeRepository extends EntityRepository implements BonusesPrizeRepositoryInterface
{
    public function getUserTotalAmount(User $user): int
    {
        $qb = $this->createQueryBuilder('bonusesPrize');
        $qb
            ->select('SUM(bonusesPrize.amount)')
            ->join('bonusesPrize.user', 'user')
            ->andWhere($qb->expr()->eq('user.id', $user->getId()))
        ;

        return $qb->getQuery()->getSingleScalarResult() ?? 0;
    }
}
