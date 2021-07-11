<?php

declare(strict_types=1);

namespace App\Handler\Factory;

use App\Handler\Usuarios\UsuariosListarHandler;
use Psr\Container\ContainerInterface;

/**
 * Class UsuariosListarHandlerFactory
 */
class UsuariosListarHandlerFactory
{
    /**
     * @param ContainerInterface
     * @return UsuariosListarHandler
     */
    public function __invoke(ContainerInterface $container): UsuariosListarHandler
    {
        return new UsuariosListarHandler($container);
    }
}
