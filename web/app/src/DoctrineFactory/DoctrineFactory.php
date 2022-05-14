<?php

namespace App\Acme\DoctrineFactory;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class DoctrineFactory
{
    private ?EntityManager $entityManager = null;

    public function getEntityManager(): EntityManager
    {
        return $this->entityManager ?? $this->createEntityManager();
    }

    private function createEntityManager(): EntityManager
    {
        $isDevMode = true;
        $proxyDir = null;
        $cache = null;
        $useSimpleAnnotationReader = false;
        $paths = [__DIR__."../Entity"];
        $config = Setup::createAnnotationMetadataConfiguration(
            $paths,
            $isDevMode,
            $proxyDir,
            $cache,
            $useSimpleAnnotationReader,
        );

// database configuration parameters
        $conn = array(
            'dbname' => 'test',
            'user' => 'dev',
            'password' => 'dev',
            'host' => 'mysql',
            'driver' => 'pdo_mysql',
        );

        return EntityManager::create($conn, $config);
    }
}
