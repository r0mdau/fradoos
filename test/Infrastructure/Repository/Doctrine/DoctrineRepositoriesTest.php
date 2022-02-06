<?php

namespace Fradoos\Infrastructure\Repository\Doctrine;

class DoctrineRepositoriesTest extends \PHPUnit\Framework\TestCase
{
    private $configuration;
    private $doctrineRepositories;

    public function setUp(): void
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
        $this->doctrineRepositories = new DoctrineRepositories($this->configuration);
    }

    public function testForCompany()
    {
        $this->assertInstanceOf(DoctrineRepositoryCompany::class, $this->doctrineRepositories->forCompany());
    }

    public function testForUser()
    {
        $this->assertInstanceOf(DoctrineRepositoryUser::class, $this->doctrineRepositories->forUser());
    }

    public function testGetEntityManager()
    {
        $this->assertEquals(
            $this->doctrineRepositories->createEntityManager($this->configuration),
            $this->doctrineRepositories->getEntityManager()
        );
    }
}