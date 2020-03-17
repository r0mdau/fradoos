<?php

namespace Fradoos\Domain;

use Doctrine\Common\Collections\ArrayCollection;

class UserTest extends \PHPUnit\Framework\TestCase
{
    public function testConstruct()
    {
        $user = new User("Georges VI", "test@example.com");

        $this->assertEquals("Georges VI", $user->getName());
    }

    public function testConstructSetEmptyWorkingGroups()
    {
        $user = new User("Georges VI", "test@example.com");

        $this->assertCount(0, $user->getWorkingGroups());
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage The user name is mandatory.
     */
    public function testConstructThrowErrorIfNameIsEmpty()
    {
        new User("", "test@example.com");
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage The user email is mandatory.
     */
    public function testConstructThrowErrorIfEmailIsEmpty()
    {
        new User("Georges V", "");
    }

    public function testGetAndSetName()
    {
        $user = new User("Elisabeth", "test@example.com");
        $this->assertEquals("Elisabeth", $user->getName());

        $user->setName("Georges V");
        $this->assertEquals("Georges V", $user->getName());
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage The user name is mandatory.
     */
    public function testSetNameThrowErrorIfNull()
    {
        $user = new User("Georges VI", "test@example.com");
        $user->setName("");
    }

    public function testGetAndSetEmail()
    {
        $user = new User("Elisabeth", "test@example.com");
        $this->assertEquals("test@example.com", $user->getEmail());

        $user->setEmail("new@example.com");
        $this->assertEquals("new@example.com", $user->getEmail());
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage The user email is mandatory.
     */
    public function testSetEmailThrowErrorIfNull()
    {
        $user = new User("Georges VI", "test@example.com");
        $user->setEmail("");
    }

    public function testAddAndGetWorkingGroup()
    {
        $user = new User("Georges VI", "test@example.com");
        $this->assertCount(0, $user->getWorkingGroups());

        $workingGroup = $this->getMockBuilder(WorkingGroup::class)->disableOriginalConstructor()->getMock();
        $user->addWorkingGroup($workingGroup);
        $this->assertCount(1, $user->getWorkingGroups());
        $this->assertSame($workingGroup, $user->getWorkingGroups()->first());
    }

    public function testAddAndGetWorkingGroupNoDuplicateObjectReference()
    {
        $user = new User("Georges VI", "test@example.com");
        $this->assertCount(0, $user->getWorkingGroups());

        $workingGroup = $this->getMockBuilder(WorkingGroup::class)->disableOriginalConstructor()->getMock();
        $user->addWorkingGroup($workingGroup);
        $user->addWorkingGroup($workingGroup);
        $this->assertCount(1, $user->getWorkingGroups());
    }

    public function testSetAndGetWorkingGroups()
    {
        $user = new User("Georges VI", "test@example.com");
        $this->assertCount(0, $user->getWorkingGroups());

        $workingGroup = $this->getMockBuilder(WorkingGroup::class)->disableOriginalConstructor()->getMock();
        $wGCollection = new ArrayCollection();
        $wGCollection->add($workingGroup);
        $user->setWorkingGroups($wGCollection);

        $this->assertCount(1, $user->getWorkingGroups());
        $this->assertSame($workingGroup, $user->getWorkingGroups()->first());
    }

    public function testSetEmptyArrayCollectionAndGetNullWorkingGroups()
    {
        $user = new User("Georges VI", "test@example.com");
        $workingGroup = $this->getMockBuilder(WorkingGroup::class)->disableOriginalConstructor()->getMock();
        $wGCollection = new ArrayCollection();
        $wGCollection->add($workingGroup);
        $user->setWorkingGroups($wGCollection);
        $this->assertCount(1, $user->getWorkingGroups());
        $this->assertSame($workingGroup, $user->getWorkingGroups()->first());

        $user->setWorkingGroups(new ArrayCollection());
        $this->assertCount(0, $user->getWorkingGroups());
    }
}