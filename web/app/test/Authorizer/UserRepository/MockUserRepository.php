<?php

namespace AppTest\Acme\Authorizer\UserRepository;

use App\Acme\Entity\User;
use App\Acme\Repository\UserRepository\UserRepositoryInterface;

class MockUserRepository implements UserRepositoryInterface
{
    private ?User $user;

    public function __construct(?User $user)
    {
        $this->user = $user;
    }

    public function findByUsername(string $username): ?User
    {
        return $this->user;
    }
}
