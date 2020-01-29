<?php

namespace Fradoos\Infrastructure\Repository\Doctrine;

use Fradoos\Domain\Helper\HelperParameter;
use Fradoos\Domain\Repository\IRepositoryUser;
use Fradoos\Domain\User;

class DoctrineRepositoryUser extends SimpleDoctrineRepository implements IRepositoryUser
{
    protected static $entity = User::class;

    public function getByName($name)
    {
        HelperParameter::checkNotEmpty($name, "Impossible to get user with empty name.");
        return $this->entityManager
            ->getRepository(User::class)
            ->findBy(['name' => $name]);
    }
}
