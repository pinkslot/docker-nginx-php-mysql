<?php

// Create a simple "default" Doctrine ORM configuration for Annotations
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Setup;

$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$paths = [__DIR__."/src/Entity"];
$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);

// database configuration parameters
$conn = array(
    'dbname' => 'test',
    'user' => 'dev',
    'password' => 'dev',
    'host' => 'mysql',
    'driver' => 'pdo_mysql',
);

$dsn = 'mysql:host=mysql;dbname=test;charset=utf8;port=3306';
$pdo = new PDO($dsn, 'dev', 'dev');

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);

return ConsoleRunner::createHelperSet($entityManager);
