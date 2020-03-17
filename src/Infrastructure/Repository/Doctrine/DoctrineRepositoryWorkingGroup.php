<?php

namespace Fradoos\Infrastructure\Repository\Doctrine;

use Fradoos\Domain\Helper\HelperParameter;
use Fradoos\Domain\Repository\IRepositoryWorkingGroup;
use Fradoos\Domain\WorkingGroup;

class DoctrineRepositoryWorkingGroup extends SimpleDoctrineRepository implements IRepositoryWorkingGroup
{
    protected static $entity = WorkingGroup::class;

    public function getByName($name)
    {
        HelperParameter::checkNotEmpty($name, "Impossible to get working group with empty name.");
        return $this->entityManager
            ->getRepository(WorkingGroup::class)
            ->findBy(['name' => $name]);
    }
}
