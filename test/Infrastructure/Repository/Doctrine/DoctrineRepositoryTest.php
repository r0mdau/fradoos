<?php

namespace Fradoos\Infrastructure\Repository\Doctrine;

class DoctrineRepositoryTest extends \PHPUnit\Framework\TestCase
{
    private $configuration;
    private $doctrineEntrepots;

    public function setUp()
    {
        $this->configuration = [
            "driver" => 'pdo_mysql',
            "host" => 'mysql-fradoos',
            "port" => '3306',
            "user" => 'root',
            "password" => 'test',
            "dbname" => 'fradoos_tu',
            "charset" => 'utf8'
        ];
        $this->doctrineEntrepots = new DoctrineRepositories($this->configuration);
    }

    public function testForUser()
    {
        $this->assertInstanceOf(DoctrineRepositoryUser::class, $this->doctrineEntrepots->forUser());
    }

    public function testGetEntityManager()
    {
        $this->assertEquals(
            $this->doctrineEntrepots->createEntityManager($this->configuration),
            $this->doctrineEntrepots->getEntityManager()
        );
    }
}