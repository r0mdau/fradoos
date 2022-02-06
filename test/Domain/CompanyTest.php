<?php

namespace Fradoos\Domain;

use Fradoos\Domain\Error\ErrorParameter;

class CompanyTest extends \PHPUnit\Framework\TestCase
{
    public function testConstruct()
    {
        $company = new Company("Georges VI");

        $this->assertEquals("Georges VI", $company->getName());
    }

    public function testConstructThrowErrorIfNameIsEmpty()
    {        
        $this->expectException(ErrorParameter::class);
        $this->expectExceptionMessage("The company name is mandatory.");
        new Company("");
    }

    public function testGetAndSetName()
    {
        $company = new Company("Elisabeth");
        $this->assertEquals("Elisabeth", $company->getName());

        $company->setName("Georges V");
        $this->assertEquals("Georges V", $company->getName());
    }
    
    public function testSetNameThrowErrorIfNull()
    {
        $this->expectException(ErrorParameter::class);
        $this->expectExceptionMessage("The company name is mandatory.");
        $company = new Company("Georges VI");
        $company->setName("");
    }
}