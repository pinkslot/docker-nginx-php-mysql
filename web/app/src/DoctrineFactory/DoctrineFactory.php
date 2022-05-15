<?php

namespace App\Acme\DoctrineFactory;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class DoctrineFactory
{
    private ?EntityManager $entityManager = null;

    public function getEntityManager(): EntityManager
    {
        $this->entityManager ??= $this->createEntityManager();

        return $this->entityManager;
    }

    private function createEntityManager(): EntityManager
    {
        $isDevMode = true;
        $proxyDir = null;
        $cache = null;
        $useSimpleAnnotationReader = false;
        $paths = [__DIR__ . '/../Entity'];
        $config = Setup::createAnnotationMetadataConfiguration(
            $paths,
            $isDevMode,
            $proxyDir,
            $cache,
            $useSimpleAnnotationReader,
        );

        $conn = array(
            'dbname' => getenv('MYSQL_DATABASE'),
            'user' => getenv('MYSQL_USER'),
            'password' => getenv('MYSQL_PASSWORD'),
            'host' => getenv('MYSQL_HOST'),
            'driver' => 'pdo_mysql',
        );

        return EntityManager::create($conn, $config);
    }
}
