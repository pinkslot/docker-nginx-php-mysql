<?php

namespace App\Acme\ServiceContainer;

use App\Acme\Authorizer\Authorizer;
use App\Acme\Authorizer\UserRepositoryInterface;
use App\Acme\Controller\AuthorizationController;
use App\Acme\Controller\PrizeController;
use App\Acme\DoctrineFactory\DoctrineFactory;
use App\Acme\Entity\User;
use Doctrine\ORM\EntityManager;

class ServiceContainer
{
    private ?EntityManager $entityManager = null;
    private ?UserRepositoryInterface $userRepository = null;
    private ?Authorizer $authorizer = null;
    private ?AuthorizationController $authorizationController = null;
    private ?PrizeController $prizeController = null;

    public function getEntityManager(): EntityManager
    {
        $this->entityManager ??= ((new DoctrineFactory())->createEntityManager());

        return $this->entityManager;
    }

    public function getUserRepository(): UserRepositoryInterface
    {
        $this->userRepository ??= $this->getEntityManager()->getRepository(User::class);

        return $this->userRepository;
    }

    public function getAuthorizer(): Authorizer
    {
        $this->authorizer ??= new Authorizer($this->getUserRepository());

        return $this->authorizer;
    }

    public function getAuthorizationController(): AuthorizationController
    {
        $this->authorizationController ??= new AuthorizationController();

        return $this->authorizationController;
    }

    public function getPrizeController(): PrizeController
    {
        $this->prizeController ??= new PrizeController();

        return $this->prizeController;
    }
}
