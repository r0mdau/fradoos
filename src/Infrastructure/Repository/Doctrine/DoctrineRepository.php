<?php

namespace Fradoos\Infrastructure\Repository\Doctrine;

abstract class DoctrineRepository
{
    protected $entityManager;

    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}