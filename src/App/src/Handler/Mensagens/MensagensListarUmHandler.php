<?php

declare(strict_types=1);

namespace App\Handler\Mensagens;

use App\Handler\HandlerAbstract;
use App\Service\MensagensService;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class MensagensListarUmHandler
 * @package App\Handler\Mensagens
 */
class MensagensListarUmHandler extends HandlerAbstract implements RequestHandlerInterface
{
    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = (int) $request->getAttribute('id');

        try {
            $service = $this->container->get(MensagensService::class);

            $resultWithoutDQL = $service->getOne($id);
            $resultWithDQL = $service->getOneWithDQL($id);

            $response = $this->successResponse([
                'message' => 'Nenhum registro encontrado',
            ]);

            if (!empty($resultWithoutDQL) && !empty($resultWithDQL)) {
                $response = $this->successResponse([
                    'result_without_dql' => $resultWithoutDQL,
                    'result_with_dql' => $resultWithDQL,
                ]);
            }
        } catch (\Exception $e) {
            $response = $this->errorResponse(
                $e,
                "Erro ao listar a mensagem com id {$id}",
                400
            );

            return $response;
        }
    }
}
