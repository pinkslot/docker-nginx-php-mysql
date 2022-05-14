<?php

namespace AppTest\Acme\Authorizer\UserRepository;

use App\Acme\Authorizer\UserRepositoryInterface;
use App\Acme\Entity\User;

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
