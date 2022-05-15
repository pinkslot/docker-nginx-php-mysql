<?php

// Create a simple "default" Doctrine ORM configuration for Annotations
use App\Acme\DoctrineFactory\DoctrineFactory;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

$factory = new DoctrineFactory();
return ConsoleRunner::createHelperSet($factory->getEntityManager());
