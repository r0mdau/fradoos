<?php

namespace Fradoos\Domain;

class CompanyTest extends \PHPUnit\Framework\TestCase
{
    public function testConstruct()
    {
        $company = new Company("Georges VI");

        $this->assertEquals("Georges VI", $company->getName());
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage The company name is mandatory.
     */
    public function testConstructThrowErrorIfNameIsEmpty()
    {
        new Company("");
    }

    public function testGetAndSetName()
    {
        $company = new Company("Elisabeth");
        $this->assertEquals("Elisabeth", $company->getName());

        $company->setName("Georges V");
        $this->assertEquals("Georges V", $company->getName());
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage The company name is mandatory.
     */
    public function testSetNameThrowErrorIfNull()
    {
        $company = new Company("Georges VI");
        $company->setName("");
    }
}