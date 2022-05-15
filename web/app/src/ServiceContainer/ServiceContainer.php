<?php

namespace App\Acme\ServiceContainer;

use App\Acme\Authorizer\Authorizer;
use App\Acme\Controller\AuthorizationController;
use App\Acme\Controller\PrizeController;
use App\Acme\DoctrineFactory\DoctrineFactory;
use App\Acme\Entity\MoneyDeposit;
use App\Acme\Entity\Prize\MoneyPrize;
use App\Acme\Entity\User;
use App\Acme\PrizeGenerator\BonusesPrizeGenerator;
use App\Acme\PrizeGenerator\CompositePrizeGenerator;
use App\Acme\PrizeGenerator\MoneyPrizeGenerator;
use App\Acme\RandomGenerator\RandomArrayElementGeneratorInterface;
use App\Acme\RandomGenerator\RandomGenerator;
use App\Acme\RandomGenerator\RandomNumberGeneratorInterface;
use App\Acme\Repository\MoneyDepositRepository\MoneyDepositRepositoryInterface;
use App\Acme\Repository\MoneyPrizeRepository\MoneyPrizeRepositoryInterface;
use App\Acme\Repository\UserRepository\UserRepositoryInterface;
use App\Acme\Service\PrizeService;
use Doctrine\ORM\EntityManagerInterface;

class ServiceContainer
{
    private ?EntityManagerInterface $entityManager = null;
    private ?UserRepositoryInterface $userRepository = null;
    private ?Authorizer $authorizer = null;
    private ?AuthorizationController $authorizationController = null;
    private ?PrizeController $prizeController = null;
    private ?PrizeService $prizeService = null;
    private ?CompositePrizeGenerator $compositePrizeGenerator = null;
    private ?MoneyPrizeGenerator $moneyPrizeGenerator = null;
    private ?BonusesPrizeGenerator $bonusesPrizeGenerator = null;
    private ?RandomGenerator $randomGenerator = null;
    private ?MoneyDepositRepositoryInterface $moneyDepositRepository = null;
    private ?MoneyPrizeRepositoryInterface $moneyPrizeRepository = null;

    public function getEntityManager(): EntityManagerInterface
    {
        $this->entityManager ??= (new DoctrineFactory())->createEntityManager();

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
        $this->prizeController ??= new PrizeController($this->getPrizeService());

        return $this->prizeController;
    }

    public function getPrizeService(): PrizeService
    {
        $this->prizeService ??= new PrizeService($this->getCompositePrizeGenerator(), $this->getEntityManager());

        return $this->prizeService;
    }

    public function getCompositePrizeGenerator(): CompositePrizeGenerator
    {
        $this->compositePrizeGenerator ??= new CompositePrizeGenerator(
            [$this->getBonusesPrizeGenerator(), $this->getMoneyPrizeGenerator()],
            $this->getRandomArrayElementGenerator(),
        );

        return $this->compositePrizeGenerator;
    }

    public function getMoneyPrizeGenerator(): MoneyPrizeGenerator
    {
        $this->moneyPrizeGenerator ??= new MoneyPrizeGenerator(
            $this->getRandomNumberGenerator(),
            $this->getMoneyDepositRepository(),
            $this->getMoneyPrizeRepository(),
        );

        return $this->moneyPrizeGenerator;
    }

    public function getBonusesPrizeGenerator(): BonusesPrizeGenerator
    {
        $this->bonusesPrizeGenerator ??= new BonusesPrizeGenerator($this->getRandomNumberGenerator());

        return $this->bonusesPrizeGenerator;
    }

    public function getRandomArrayElementGenerator(): RandomArrayElementGeneratorInterface
    {
        $this->randomGenerator ??= new RandomGenerator();

        return $this->randomGenerator;
    }

    public function getRandomNumberGenerator(): RandomNumberGeneratorInterface
    {
        $this->randomGenerator ??= new RandomGenerator();

        return $this->randomGenerator;
    }

    public function getMoneyDepositRepository(): ?MoneyDepositRepositoryInterface
    {
        $this->moneyDepositRepository ??= $this->getEntityManager()->getRepository(MoneyDeposit::class);

        return $this->moneyDepositRepository;
    }

    public function getMoneyPrizeRepository(): ?MoneyPrizeRepositoryInterface
    {
        $this->moneyPrizeRepository ??= $this->getEntityManager()->getRepository(MoneyPrize::class);

        return $this->moneyPrizeRepository;
    }
}
