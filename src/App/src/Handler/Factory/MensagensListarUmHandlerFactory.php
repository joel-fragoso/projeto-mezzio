<?php

declare(strict_types=1);

namespace App\Handler\Factory;

use App\Handler\Mensagens\MensagensListarUmHandler;
use Psr\Container\ContainerInterface;

/**
 * Class MensagensListarUmHandlerFactory
 * @package App\Handler\Factory
 */
class MensagensListarUmHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return MensagensListarUmHandler
     */
    public function __invoke(ContainerInterface $container): MensagensListarUmHandler
    {
        return new MensagensListarUmHandler($container);
    }
}
