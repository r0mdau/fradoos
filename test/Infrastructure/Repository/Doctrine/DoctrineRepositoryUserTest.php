<?php

namespace Fradoos\Infrastructure\Repository\Doctrine;

use Fradoos\Domain\User;

class DoctrineRepositoryUserTest extends DoctrineRepositoryTestCase
{
    private $userRepository;

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Impossible to add empty Fradoos\Domain\User.
     */
    public function testAddThrowExceptionIfNull()
    {
        $this->userRepository->add(null);
    }

    public function testAdd()
    {
        $user = new User("Georges V", "test@example.com");

        $this->userRepository->add($user);

        $result = $this->userRepository->get($user->getId());

        $this->assertEquals($user, $result);
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Impossible to edit empty Fradoos\Domain\User.
     */
    public function testEditThrowErrorIfNull()
    {
        $this->userRepository->edit(null);
    }

    public function testEdit()
    {
        $user = new User("Georges V", "test@example.com");
        $this->persistInDatabase($user);

        $user->setName("Elisabeth");
        $this->userRepository->edit($user);

        $result = $this->userRepository->get($user->getId());

        $this->assertEquals($user, $result);
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Impossible to get Fradoos\Domain\User with empty id.
     */
    public function testGetThrowErrorIfNull()
    {
        $this->userRepository->get(null);
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorEntityNotFound
     * @expectedExceptionMessage Impossible to get Fradoos\Domain\User with id: 9999.
     */
    public function testThrowErrorIfIdNotExist()
    {
        $this->userRepository->get(9999);
    }

    public function testGet()
    {
        $user = new User("Charles", "test@example.com");
        $this->persistInDatabase($user);

        $result = $this->userRepository->get($user->getId());

        $this->assertEquals($user, $result);
    }

    public function testGetByName()
    {
        $user = new User("Georges VI", "test@example.com");
        $this->persistInDatabase($user);

        $result = $this->userRepository->getByName($user->getName());

        $this->assertEquals([$user], $result);
    }

    public function testGetAll()
    {
        $this->persistInDatabase(new User("Georges V", "test@example.com"));
        $result = $this->userRepository->getAll();

        $this->assertTrue(is_array($result));
        $this->assertTrue($result[0] instanceof User);
    }

    protected function setUp()
    {
        parent::setUp();
        $this->userRepository = new DoctrineRepositoryUser($this->entityManager);
    }
}