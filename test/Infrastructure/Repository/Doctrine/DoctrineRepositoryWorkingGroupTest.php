<?php

namespace Fradoos\Infrastructure\Repository\Doctrine;

use Fradoos\Domain\Error\ErrorEntityNotFound;
use Fradoos\Domain\Error\ErrorParameter;
use Fradoos\Domain\WorkingGroup;

class DoctrineRepositoryWorkingGroupTest extends DoctrineRepositoryTestCase
{
    private $groupRepository;

    public function testAddThrowExceptionIfNull()
    {
        $this->expectException(ErrorParameter::class);
        $this->expectExceptionMessage("Impossible to add empty Fradoos\Domain\WorkingGroup.");

        $this->groupRepository->add(null);
    }

    public function testAdd()
    {
        $group = new WorkingGroup("Georges V");

        $this->groupRepository->add($group);

        $result = $this->groupRepository->get($group->getId());

        $this->assertEquals($group, $result);
    }

    public function testEditThrowErrorIfNull()
    {
        $this->expectException(ErrorParameter::class);
        $this->expectExceptionMessage("Impossible to edit empty Fradoos\Domain\WorkingGroup.");

        $this->groupRepository->edit(null);
    }

    public function testEdit()
    {
        $group = new WorkingGroup("Georges V");
        $this->persistInDatabase($group);

        $group->setName("Elisabeth");
        $this->groupRepository->edit($group);

        $result = $this->groupRepository->get($group->getId());

        $this->assertEquals($group, $result);
    }

    public function testGetThrowErrorIfNull()
    {
        $this->expectException(ErrorParameter::class);
        $this->expectExceptionMessage("Impossible to get Fradoos\Domain\WorkingGroup with empty id.");

        $this->groupRepository->get(null);
    }

    public function testThrowErrorIfIdNotExist()
    {
        $this->expectException(ErrorEntityNotFound::class);
        $this->expectExceptionMessage("Impossible to get Fradoos\Domain\WorkingGroup with id: 9999.");

        $this->groupRepository->get(9999);
    }

    public function testGet()
    {
        $group = new WorkingGroup("Charles");
        $this->persistInDatabase($group);

        $result = $this->groupRepository->get($group->getId());

        $this->assertEquals($group, $result);
    }

    public function testGetByName()
    {
        $group = new WorkingGroup("Georges VI");
        $this->persistInDatabase($group);

        $result = $this->groupRepository->getByName($group->getName());

        $this->assertEquals([$group], $result);
    }

    public function testGetAll()
    {
        $this->persistInDatabase(new WorkingGroup("Georges V"));
        $result = $this->groupRepository->getAll();

        $this->assertTrue(is_array($result));
        $this->assertTrue($result[0] instanceof WorkingGroup);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->groupRepository = new DoctrineRepositoryWorkingGroup($this->entityManager);
    }
}