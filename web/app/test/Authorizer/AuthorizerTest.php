<?php

namespace AppTest\Acme\Authorizer;

use App\Acme\Authorizer\Authorizer;
use App\Acme\Entity\User;
use AppTest\Acme\Authorizer\UserRepository\MockUserRepository;
use PHPUnit\Framework\TestCase;

class AuthorizerTest extends TestCase
{
    /** @dataProvider cases */
    public function testAuthorize(string $username, string $password, ?User $fromProvider, ?User $expectation)
    {
        $userRepository = new MockUserRepository($fromProvider);
        $authorizer = new Authorizer($userRepository);

        $result = $authorizer->authorize($username, $password);
        $this->assertEquals($expectation, $result);
    }

    public function cases(): array
    {
        $user = new User('user', 'pass');

        return [
            'success_case' => ['user', 'pass', $user, $user],
            'user_not_found' => ['user1', 'pass', null, null],
            'bad_password' => ['user', 'pass1', $user, null],
        ];
    }
}
