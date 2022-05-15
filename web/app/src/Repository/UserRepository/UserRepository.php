<?php

namespace App\Acme\Repository\UserRepository;

use App\Acme\Entity\User;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository implements UserRepositoryInterface
{
    public function findByUsername(string $username): ?User
    {
        return $this->findOneBy(['username' => $username]);
    }
}
