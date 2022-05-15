<?php

namespace App\Acme;

use App\Acme\Authorizer\Authorizer;
use App\Acme\Authorizer\UserRepositoryInterface;
use App\Acme\DoctrineFactory\DoctrineFactory;
use App\Acme\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * I belong to a class
 */
class Kernel
{
    private function needAuthorization(): Response
    {
        return new Response(null, Response::HTTP_UNAUTHORIZED, [
            'WWW-Authenticate' => 'Basic realm="Acme"',
            'php-auth-user' => null,
            'php-auth-pw' => null,
        ]);
    }

    /**
     * Gets the name of the application.
     */
    public function handleHttpRequest(Request $request): Response
    {
        $entityManager = ((new DoctrineFactory())->getEntityManager());
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = $entityManager->getRepository(User::class);
        $authorizer = new Authorizer($userRepository);

        $username = $request->headers->get('php-auth-user');
        $password = $request->headers->get('php-auth-pw');

        if ($username === null || $password === null) {
            return $this->needAuthorization();
        }

        $user = $authorizer->authorize($username, $password);

        if ($user === null) {
            return $this->needAuthorization();
        }

        $path = $request->getPathInfo();
        $method = $request->getMethod();
        if ($path === '/take-prize' && $method == 'POST') {
            return new JsonResponse(['money' => $path, 'bonuses' => $method]);
        }
        if ($path === '/state' && $method == 'GET') {
            return new JsonResponse(['money' => $path, 'bonuses' => $method]);
        }

        return new Response(file_get_contents(__DIR__ . '/../template/index.html'));
    }
}
