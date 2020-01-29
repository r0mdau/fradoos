<?php

namespace Fradoos\Infrastructure\Repository\Doctrine;

use Fradoos\Domain\Error\ErrorEntityNotFound;
use Fradoos\Domain\Helper\HelperParameter;
use Fradoos\Domain\Repository\ISimpleDoctrineRepository;

class SimpleDoctrineRepository extends DoctrineRepository implements ISimpleDoctrineRepository
{
    /**
     * @var null
     */
    protected static $entity = null;

    public function add($entity)
    {
        HelperParameter::checkNotEmpty($entity, "Impossible to add empty " . static::$entity . ".");
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        return $entity;
    }

    public function delete($id)
    {
        HelperParameter::checkNotEmpty($id, "Impossible to delete " . static::$entity . " with empty id.");
        $entity = $this->get($id);
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    public function get($id)
    {
        HelperParameter::checkNotEmpty($id, "Impossible to get " . static::$entity . " with empty id.");
        $entity = $this->entityManager->find(static::$entity, $id);
        if (is_null($entity)) {
            throw new ErrorEntityNotFound("Impossible to get " . static::$entity . " with id: $id.");
        }
        return $entity;
    }

    public function edit($entity)
    {
        HelperParameter::checkNotEmpty($entity, "Impossible to edit empty " . static::$entity . ".");
        $this->entityManager->flush();
        return $entity;
    }

    public function getAll()
    {
        return $this->entityManager
            ->getRepository(static::$entity)
            ->findAll();
    }
}
