<?php

namespace Fradoos\Infrastructure\Repository\Doctrine;

use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\Mapping\Driver\PHPDriver;
use Fradoos\Domain\Repository\Repositories;

class DoctrineRepositories extends Repositories
{
    protected $entityManager;

    public function __construct($configurationConnexion)
    {
        $this->entityManager = $this->createEntityManager($configurationConnexion);
    }

    public static function createEntityManager($configurationConnexion)
    {
        $configuration = new Configuration();
        $configuration->setMetadataCacheImpl(new \Doctrine\Common\Cache\ApcuCache());
        $configuration->setQueryCacheImpl(new \Doctrine\Common\Cache\ApcuCache());
        $configuration->setResultCacheImpl(new \Doctrine\Common\Cache\ApcuCache());

        $cacheConfig = new \Doctrine\ORM\Cache\CacheConfiguration();
        $factory = new \Doctrine\ORM\Cache\DefaultCacheFactory($cacheConfig->getRegionsConfiguration(), new \Doctrine\Common\Cache\ApcuCache());
        $configuration->setSecondLevelCacheEnabled();
        $configuration->getSecondLevelCacheConfiguration()->setCacheFactory($factory);

        $configuration->setAutoGenerateProxyClasses(true);
        $configuration->setMetadataDriverImpl(new PHPDriver(__DIR__ . "/Mapping"));
        $configuration->setProxyDir(__DIR__ . "/../../../../generated/Fradoos/Infrastructure/Repository/Doctrine/Proxy");
        $configuration->setProxyNamespace("Fradoos\Infrastructure\Repository\Doctrine\Proxy");
        return EntityManager::create($configurationConnexion, $configuration);
    }

    /**
     * @return DoctrineRepositoryUser
     */
    public function forUser()
    {
        return new DoctrineRepositoryUser($this->entityManager);
    }

    /**
     * @return DoctrineRepositoryCompany
     */
    public function forCompany()
    {
        return new DoctrineRepositoryCompany($this->entityManager);
    }

    /**
     * @return DoctrineRepositoryWorkingGroup
     */
    public function forWorkingGroup()
    {
        return new DoctrineRepositoryWorkingGroup($this->entityManager);
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }

    public function beginTransaction()
    {
        $this->entityManager->beginTransaction();
    }

    public function rollback()
    {
        $this->entityManager->rollback();
    }

    public function commit()
    {
        $this->entityManager->flush();
        $this->entityManager->commit();
    }
}