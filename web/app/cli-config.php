<?php

// Create a simple "default" Doctrine ORM configuration for Annotations
use Doctrine\ORM\Tools\Console\ConsoleRunner;

$factory = new DoctrineFactory();
return ConsoleRunner::createHelperSet($factory->getEntityManager());
