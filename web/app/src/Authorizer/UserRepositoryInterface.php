<?php

namespace App\Acme\Authorizer;

use App\Acme\Entity\User;

interface UserRepositoryInterface
{
    public function findByUsername(string $username): ?User;
}
