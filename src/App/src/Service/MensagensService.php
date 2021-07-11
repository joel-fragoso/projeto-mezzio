<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Mensagens;
use App\Entity\Usuarios;
use Laminas\Hydrator\ClassMethodsHydrator;

/**
 * Class MensagensService
 * @package App\Service
 */
class MensagensService extends ServiceAbstract
{
    protected $entity = Mensagens::class;

    /**
     * {@inheritdoc}
     */
    public function insert(array $data): array
    {
        try {
            $entity = new $this->entity();

            $user = $this->entityManager->getReference(Usuarios::class, $data['usuario']);

            $data['usuario'] = $user;
            $data['dataMensagem'] = new \DateTime('now');

            $classMethods = new ClassMethodsHydrator();
            $classMethods->hydrate($data, $entity);

            $this->entityManager->persist($entity);
            $this->entityManager->flush();

            return $entity->toArray();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function update(array $data): array
    {
        try {
            $entity = $this->entityManager->getReference($this->entity, $data['id']);

            if (!empty($data['usuario'])) {
                $user = $this->entityManager->getReference(Usuarios::class, $data['usuario']);

                $data['usuario'] = $user;
            }

            $classMethods = new ClassMethodsHydrator();
            $classMethods->hydrate($data, $entity);

            $this->entityManager->persist($entity);
            $this->entityManager->flush();

            return $entity->toArray();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
