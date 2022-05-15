<?php

// Create a simple "default" Doctrine ORM configuration for Annotations
use App\Acme\ServiceContainer\ServiceContainer;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

$container = new ServiceContainer();
return ConsoleRunner::createHelperSet($container->getEntityManager());
