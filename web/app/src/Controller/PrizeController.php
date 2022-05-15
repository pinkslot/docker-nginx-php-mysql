<?php

namespace App\Acme\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PrizeController
{
    public function getState(): Response
    {
        return new JsonResponse(['money' => 'money', 'bonuses' => 'bonuses']);
    }

    public function takePrize(): Response
    {
        return new JsonResponse(['money' => 'mone1y', 'bonuses' => 'bonuses1']);
    }
}
