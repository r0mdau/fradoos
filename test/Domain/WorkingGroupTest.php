<?php

namespace Fradoos\Domain;

class WorkingGroupTest extends \PHPUnit\Framework\TestCase
{
    public function testConstruct()
    {
        $group = new WorkingGroup("Georges VI");

        $this->assertEquals("Georges VI", $group->getName());
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage The workingGroup name is mandatory.
     */
    public function testConstructThrowErrorIfNameIsEmpty()
    {
        new WorkingGroup("");
    }

    public function testGetAndSetName()
    {
        $group = new WorkingGroup("Elisabeth");
        $this->assertEquals("Elisabeth", $group->getName());

        $group->setName("Georges V");
        $this->assertEquals("Georges V", $group->getName());
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage The workingGroup name is mandatory.
     */
    public function testSetNameThrowErrorIfNull()
    {
        $group = new WorkingGroup("Georges VI");
        $group->setName("");
    }
}