<?php

declare(strict_types=1);

namespace App\Handler\Mensagens;

use App\Handler\HandlerAbstract;
use App\Service\MensagensService;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class MensagensListarHandler
 * @package App\Handler\Mensagens
 */
class MensagensListarHandler extends HandlerAbstract implements RequestHandlerInterface
{
    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $service = $this->container->get(MensagensService::class);

            $resultWithoutDQL = $service->getAll();
            $resultWithDQL = $service->getAllWithDQL();

            $response = $this->successResponse([
                'result_without_dql' => $resultWithoutDQL,
                'result_with_dql' => $resultWithDQL,
            ]);
        } catch (\Exception $e) {
            $response = $this->errorResponse(
                $e,
                'Erro ao listar todas as mensagens',
                400
            );
        }

        return $response;
    }
}
