<?php

namespace Fradoos\Infrastructure\Repository\Doctrine;

use Fradoos\Domain\Helper\HelperParameter;
use Fradoos\Domain\Repository\IRepositoryCompany;
use Fradoos\Domain\Company;

class DoctrineRepositoryCompany extends SimpleDoctrineRepository implements IRepositoryCompany
{
    protected static $entity = Company::class;

    public function getByName($name)
    {
        HelperParameter::checkNotEmpty($name, "Impossible to get company with empty name.");
        return $this->entityManager
            ->getRepository(Company::class)
            ->findBy(['name' => $name]);
    }
}
