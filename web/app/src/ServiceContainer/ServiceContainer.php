<?php

namespace App\Acme\ServiceContainer;

use App\Acme\Authorizer\Authorizer;
use App\Acme\Controller\AuthorizationController;
use App\Acme\Controller\PrizeController;
use App\Acme\DoctrineFactory\DoctrineFactory;
use App\Acme\Entity\MoneyDeposit;
use App\Acme\Entity\Prize\BonusesPrize;
use App\Acme\Entity\Prize\MoneyPrize;
use App\Acme\Entity\User;
use App\Acme\PrizeGenerator\BonusesPrizeGenerator;
use App\Acme\PrizeGenerator\CompositePrizeGenerator;
use App\Acme\PrizeGenerator\MoneyPrizeGenerator;
use App\Acme\RandomGenerator\RandomGenerator;
use App\Acme\Repository\BonusesPrizeRepository\BonusesPrizeRepositoryInterface;
use App\Acme\Repository\MoneyDepositRepository\MoneyDepositRepositoryInterface;
use App\Acme\Repository\MoneyPrizeRepository\MoneyPrizeRepositoryInterface;
use App\Acme\Repository\UserRepository\UserRepositoryInterface;
use App\Acme\Service\PrizeService\PrizeService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use ProxyManager\Factory\LazyLoadingValueHolderFactory;

class ServiceContainer
{
    private LazyLoadingValueHolderFactory $lazyLoadingProxyFactory;

    private EntityManager $entityManager;
    private Authorizer $authorizer;
    private AuthorizationController $authorizationController;
    private PrizeController $prizeController;
    private PrizeService $prizeService;
    private CompositePrizeGenerator $compositePrizeGenerator;
    private MoneyPrizeGenerator $moneyPrizeGenerator;
    private BonusesPrizeGenerator $bonusesPrizeGenerator;
    private RandomGenerator $randomGenerator;

    public function __construct()
    {
        $this->lazyLoadingProxyFactory = new LazyLoadingValueHolderFactory();
        $this->initAuthorizationController();
        $this->initAuthorizer();
        $this->initBonusesPrizeGenerator();
        $this->initCompositePrizeGenerator();
        $this->initEntityManager();
        $this->initMoneyPrizeGenerator();
        $this->initPrizeController();
        $this->initPrizeService();
        $this->initRandomGenerator();
    }

    public function initEntityManager(): void
    {
        $this->entityManager = $this->lazyLoadingProxyFactory->createProxy(
            EntityManager::class,
            function (&$wrappedObject, $proxy, $method, $parameters, &$initializer) {
                $wrappedObject = (new DoctrineFactory())->createEntityManager();
                $initializer   = null;

                return true;
            }
        );
    }

    public function initAuthorizer(): void
    {
        $this->authorizer = $this->lazyLoadingProxyFactory->createProxy(
            Authorizer::class,
            function (&$wrappedObject, $proxy, $method, $parameters, &$initializer) {
                $wrappedObject = new Authorizer($this->getUserRepository());
                $initializer   = null;

                return true;
            }
        );
    }

    public function initAuthorizationController(): void
    {
        $this->authorizationController = $this->lazyLoadingProxyFactory->createProxy(
            AuthorizationController::class,
            function (&$wrappedObject, $proxy, $method, $parameters, &$initializer) {
                $wrappedObject = new AuthorizationController();
                $initializer   = null;

                return true;
            }
        );
    }

    public function initPrizeController(): void
    {
        $this->prizeController = $this->lazyLoadingProxyFactory->createProxy(
            PrizeController::class,
            function (&$wrappedObject, $proxy, $method, $parameters, &$initializer) {
                $wrappedObject = new PrizeController($this->prizeService);
                $initializer   = null;

                return true;
            }
        );
    }

    public function initPrizeService(): void
    {
        $this->prizeService = $this->lazyLoadingProxyFactory->createProxy(
            PrizeService::class,
            function (&$wrappedObject, $proxy, $method, $parameters, &$initializer) {
                $wrappedObject = new PrizeService(
                    $this->compositePrizeGenerator,
                    $this->entityManager,
                    $this->getMoneyDepositRepository(),
                    $this->getMoneyPrizeRepository(),
                    $this->getBonusesPrizeRepository(),
                );
                $initializer   = null;

                return true;
            }
        );
    }

    public function initCompositePrizeGenerator(): void
    {
        $this->compositePrizeGenerator = $this->lazyLoadingProxyFactory->createProxy(
            CompositePrizeGenerator::class,
            function (&$wrappedObject, $proxy, $method, $parameters, &$initializer) {
                $wrappedObject = new CompositePrizeGenerator(
                    [$this->bonusesPrizeGenerator, $this->moneyPrizeGenerator],
                    $this->randomGenerator,
                );
                $initializer   = null;

                return true;
            }
        );
    }

    public function initMoneyPrizeGenerator(): void
    {
        $this->moneyPrizeGenerator = $this->lazyLoadingProxyFactory->createProxy(
            MoneyPrizeGenerator::class,
            function (&$wrappedObject, $proxy, $method, $parameters, &$initializer) {
                $wrappedObject = new MoneyPrizeGenerator(
                    $this->randomGenerator,
                    $this->getMoneyDepositRepository(),
                    $this->getMoneyPrizeRepository(),
                );
                $initializer   = null;

                return true;
            }
        );
    }

    public function initBonusesPrizeGenerator(): void
    {
        $this->bonusesPrizeGenerator = $this->lazyLoadingProxyFactory->createProxy(
            BonusesPrizeGenerator::class,
            function (&$wrappedObject, $proxy, $method, $parameters, &$initializer) {
                $wrappedObject = new BonusesPrizeGenerator($this->randomGenerator);
                $initializer   = null;

                return true;
            }
        );
    }

    public function initRandomGenerator(): void
    {
        $this->randomGenerator = $this->lazyLoadingProxyFactory->createProxy(
            RandomGenerator::class,
            function (&$wrappedObject, $proxy, $method, $parameters, &$initializer) {
                $wrappedObject = new RandomGenerator();
                $initializer   = null;

                return true;
            }
        );
    }

    public function getUserRepository(): UserRepositoryInterface
    {
        return $this->entityManager->getRepository(User::class);
    }

    public function getMoneyDepositRepository(): MoneyDepositRepositoryInterface
    {
        return $this->entityManager->getRepository(MoneyDeposit::class);
    }

    public function getMoneyPrizeRepository(): MoneyPrizeRepositoryInterface
    {
        return $this->entityManager->getRepository(MoneyPrize::class);
    }

    public function getBonusesPrizeRepository(): BonusesPrizeRepositoryInterface
    {
        return $this->entityManager->getRepository(BonusesPrize::class);
    }

    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    public function getAuthorizer(): Authorizer
    {
        return $this->authorizer;
    }

    public function getAuthorizationController(): AuthorizationController
    {
        return $this->authorizationController;
    }

    public function getPrizeController(): PrizeController
    {
        return $this->prizeController;
    }
}
