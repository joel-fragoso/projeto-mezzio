<?php

declare(strict_types=1);

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\EntityManager;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

/** @var \Interop\Container\ContainerInterface $container */
$container = require 'config/container.php';

/** @var \Doctrine\ORM\EntityManager $entityManager */
$entityManager = $container->get(EntityManager::class);

return ConsoleRunner::createHelperSet($entityManager);
