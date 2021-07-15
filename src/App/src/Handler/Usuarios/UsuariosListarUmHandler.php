<?php

declare(strict_types=1);

namespace App\Handler\Usuarios;

use App\Handler\HandlerAbstract;
use App\Service\UsuariosService;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class UsuariosListarUmHandler
 * @package App\Handler\Usuarios
 */
class UsuariosListarUmHandler extends HandlerAbstract implements RequestHandlerInterface
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = (int) $request->getAttribute('id');

        try {
            $service = $this->container->get(UsuariosService::class);

            $resultWithoutDQL = $service->getOne($id);
            $resultWithDQL = $service->getOneWithDQL($id);

            $response = $this->successResponse([
                'message' => 'Nenhum registro encontrado',
            ], 404);

            if (!empty($resultWithoutDQL) && !empty($resultWithDQL)) {
                $response = $this->successResponse([
                    'result_without_dql' => $resultWithoutDQL,
                    'result_with_dql' => $resultWithDQL,
                ]);
            }
        } catch (\Exception $e) {
            $response = $this->errorResponse(
                $e,
                "Erro ao listar o usuário com o id {$id}",
                400
            );
        }

        return $response;
    }
}
