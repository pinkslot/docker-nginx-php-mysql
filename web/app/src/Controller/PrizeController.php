<?php

namespace App\Acme\Controller;

use App\Acme\Entity\User;
use App\Acme\Service\PrizeService\PrizeService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PrizeController
{
    private PrizeService $prizeService;

    public function __construct(PrizeService $prizeService)
    {
        $this->prizeService = $prizeService;
    }

    public function getState(User $user): Response
    {
        return new JsonResponse($this->prizeService->getState($user));
    }

    public function takePrize(User $user): Response
    {
        $this->prizeService->generatePrize($user);

        return new JsonResponse($this->prizeService->getState($user));
    }
}
