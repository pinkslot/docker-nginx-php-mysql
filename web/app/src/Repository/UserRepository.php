<?php

namespace App\Acme\Repository;

use App\Acme\Authorizer\UserRepositoryInterface;
use App\Acme\Entity\User;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository implements UserRepositoryInterface
{
    public function findByUsername(string $username): ?User
    {
        return $this->findOneBy(['username' => $username]);
    }
}
