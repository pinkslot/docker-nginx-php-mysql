<?php

namespace App\Acme;

use App\Acme\ServiceContainer\ServiceContainer;
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
        $username = $request->headers->get('php-auth-user');
        $password = $request->headers->get('php-auth-pw');

        $container = new ServiceContainer();

        if ($username === null || $password === null) {
            return $container->getAuthorizationController()->redirectToAuthorize();
        }

        $user = $container->getAuthorizer()->authorize($username, $password);

        if ($user === null) {
            return $container->getAuthorizationController()->redirectToAuthorize();
        }

        $path = $request->getPathInfo();
        $method = $request->getMethod();
        if ($path === '/take-prize' && $method == 'POST') {
            return $container->getPrizeController()->takePrize($user);
        }
        if ($path === '/state' && $method == 'GET') {
            return $container->getPrizeController()->getState($user);
        }

        return new Response(file_get_contents(__DIR__ . '/../template/index.html'));
    }
}
