<?php

namespace App\Acme\Authorizer;

use App\Acme\Entity\User;

class Authorizer
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function authorize(string $username, string $password): ?User
    {
        $user = $this->userRepository->findByUsername($username);
        if ($user === null) {
            return null;
        }

        if (!password_verify($password, $user->getPasswordHash())) {
            return null;
        }

        return $user;
    }
}
