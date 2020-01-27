<?php

namespace Fradoos\Domain;

class UserTest extends \PHPUnit\Framework\TestCase
{
    public function testConstruct()
    {
        $user = new User("Georges VI");

        $this->assertEquals("Georges VI", $user->getName());
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage The user name is mandatory.
     */
    public function testConstructThrowErrorIfNameIsEmpty()
    {
        new User(null);
    }

    public function testGetAndSetName()
    {
        $user = new User("Elisabeth");
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
        $user = new User("Georges VI");
        $user->setName(null);
    }
}