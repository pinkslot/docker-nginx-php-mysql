<?php

namespace App\Acme\Repository\UserRepository;

use App\Acme\Entity\User;

interface UserRepositoryInterface
{
    public function findByUsername(string $username): ?User;
}
