<?php

namespace App\Acme\Controller;

use Symfony\Component\HttpFoundation\Response;

class AuthorizationController
{
    public function redirectToAuthorize(): Response
    {
        return new Response(null, Response::HTTP_UNAUTHORIZED, [
            'WWW-Authenticate' => 'Basic realm="Acme"',
            'php-auth-user' => null,
            'php-auth-pw' => null,
        ]);
    }
}
