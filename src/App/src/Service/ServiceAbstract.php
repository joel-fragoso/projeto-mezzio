<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\EntityManager;
use Laminas\Hydrator\ClassMethodsHydrator;

/**
 * Class ServiceAbstract
 * @package App\Service
 */
abstract class ServiceAbstract
{
    /** @var EntityManager */
    protected $entityManager;

    /** @var string */
    protected $entity;

    /**
     * ServiceAbstract construtor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getAll(): array
    {
        try {
            $repository = $this->entityManager->getRepository($this->entity);

            return $repository->getAll();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param int $id
     * @return array
     * @throws \Exception
     */
    public function getOne(int $id): array
    {
        try {
            $repository = $this->entityManager->getRepository($this->entity);

            return $repository->getOne($id);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getAllWithDQL(): array
    {
        try {
            $repository = $this->entityManager->getRepository($this->entity);

            return $repository->getAllWithDQL();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param int $id
     * @return array
     * @throws \Exception
     */
    public function getOneWithDQL(int $id): array
    {
        try {
            $repository = $this->entityManager->getRepository($this->entity);

            return $repository->getOneWithDQL($id);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function insert(array $data): array
    {
        try {
            $entity = new $this->entity();

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
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function update(array $data): array
    {
        try {
            $entity = $this->entityManager->getReference($this->entity, $data['id']);

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
     * @param int $id
     * @throws \Exception
     */
    public function delete(int $id): void
    {
        try {
            $entity = $this->entityManager->getReference($this->entity, $id);

            $this->entityManager->remove($entity);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
