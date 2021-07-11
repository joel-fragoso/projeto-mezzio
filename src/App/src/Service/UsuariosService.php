<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\TiposUsuario;
use App\Entity\Usuarios;
use Laminas\Hydrator\ClassMethodsHydrator;

/**
 * Class UsuariosService
 * @package App\Service
 */
class UsuariosService extends ServiceAbstract
{
    protected $entity = Usuarios::class;

    /**
     * {@inheritdoc}
     */
    public function insert(array $data): array
    {
        try {
            $entity = new $this->entity();

            $userType = $this->entityManager->getReference(TiposUsuario::class, $data['tipoUsuario']);

            $data['tipoUsuario'] = $userType;
            $data['dataNascimento'] = new \DateTime($data['dataNascimento']);

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

            if (!empty($data['tipoUsuario'])) {
                $userType = $this->entityManager->getReference(TiposUsuario::class, $data['tipoUsuario']);

                $data['tipoUsuario'] = $userType;
            }

            if (!empty($data['dataNascimento'])) {
                $data['dataNascimento'] = new \DateTime($data['dataNascimento']);
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
