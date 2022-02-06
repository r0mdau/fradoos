<?php

namespace Fradoos\Domain;

use Fradoos\Domain\Error\ErrorParameter;

class WorkingGroupTest extends \PHPUnit\Framework\TestCase
{
    public function testConstruct()
    {
        $group = new WorkingGroup("Georges VI");

        $this->assertEquals("Georges VI", $group->getName());
    }

    public function testConstructThrowErrorIfNameIsEmpty()
    {
        $this->expectException(ErrorParameter::class);
        $this->expectExceptionMessage("The workingGroup name is mandatory.");

        new WorkingGroup("");
    }

    public function testGetAndSetName()
    {
        $group = new WorkingGroup("Elisabeth");
        $this->assertEquals("Elisabeth", $group->getName());

        $group->setName("Georges V");
        $this->assertEquals("Georges V", $group->getName());
    }

    public function testSetNameThrowErrorIfNull()
    {
        $this->expectException(ErrorParameter::class);
        $this->expectExceptionMessage("The workingGroup name is mandatory.");

        $group = new WorkingGroup("Georges VI");
        $group->setName("");
    }
}