<?php

namespace Fradoos\Infrastructure\Repository\Doctrine;

use Fradoos\Domain\Company;

class DoctrineRepositoryCompanyTest extends DoctrineRepositoryTestCase
{
    private $companyRepository;

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Impossible to add empty Fradoos\Domain\Company.
     */
    public function testAddThrowExceptionIfNull()
    {
        $this->companyRepository->add(null);
    }

    public function testAdd()
    {
        $company = new Company("Georges V");

        $this->companyRepository->add($company);

        $result = $this->companyRepository->get($company->getId());

        $this->assertEquals($company, $result);
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Impossible to edit empty Fradoos\Domain\Company.
     */
    public function testEditThrowErrorIfNull()
    {
        $this->companyRepository->edit(null);
    }

    public function testEdit()
    {
        $company = new Company("Georges V");
        $this->persistInDatabase($company);

        $company->setName("Elisabeth");
        $this->companyRepository->edit($company);

        $result = $this->companyRepository->get($company->getId());

        $this->assertEquals($company, $result);
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Impossible to get Fradoos\Domain\Company with empty id.
     */
    public function testGetThrowErrorIfNull()
    {
        $this->companyRepository->get(null);
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorEntityNotFound
     * @expectedExceptionMessage Impossible to get Fradoos\Domain\Company with id: 9999.
     */
    public function testThrowErrorIfIdNotExist()
    {
        $this->companyRepository->get(9999);
    }

    public function testGet()
    {
        $company = new Company("Charles");
        $this->persistInDatabase($company);

        $result = $this->companyRepository->get($company->getId());

        $this->assertEquals($company, $result);
    }

    public function testGetByName()
    {
        $company = new Company("Georges VI");
        $this->persistInDatabase($company);

        $result = $this->companyRepository->getByName($company->getName());

        $this->assertEquals([$company], $result);
    }

    public function testGetAll()
    {
        $this->persistInDatabase(new Company("Georges V"));
        $result = $this->companyRepository->getAll();

        $this->assertTrue(is_array($result));
        $this->assertTrue($result[0] instanceof Company);
    }

    protected function setUp()
    {
        parent::setUp();
        $this->companyRepository = new DoctrineRepositoryCompany($this->entityManager);
    }
}