<?php

namespace App\Acme;

use App\Acme\DoctrineFactory\DoctrineFactory;
use App\Acme\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * I belong to a class
 */
class Kernel
{
    /**
     * Gets the name of the application.
     */
    public function handleHttpRequest(Request $request): Response
    {
        $entityManager = ((new DoctrineFactory())->getEntityManager());
        $userRepository = $entityManager->getRepository(User::class);

        $username = $request->headers->get('php-auth-user');
        $password = $request->headers->get('php-auth-pw');

        /** @var User $user */
        $user = $userRepository->findOneBy([
            'username' => $username,
        ]);

        if ($user === null || !password_verify($password, $user->getPasswordHash())) {
            return new Response(null, Response::HTTP_UNAUTHORIZED, [
                'WWW-Authenticate' => 'Basic realm="Acme"',
                'php-auth-user' => null,
                'php-auth-pw' => null,
            ]);
        }

        return new Response($username);
    }
}
