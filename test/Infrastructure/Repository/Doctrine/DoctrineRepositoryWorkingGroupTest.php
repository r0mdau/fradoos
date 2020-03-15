<?php

namespace Fradoos\Infrastructure\Repository\Doctrine;

use Fradoos\Domain\WorkingGroup;

class DoctrineRepositoryWorkingGroupTest extends DoctrineRepositoryTestCase
{
    private $groupRepository;

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Impossible to add empty Fradoos\Domain\WorkingGroup.
     */
    public function testAddThrowExceptionIfNull()
    {
        $this->groupRepository->add(null);
    }

    public function testAdd()
    {
        $group = new WorkingGroup("Georges V");

        $this->groupRepository->add($group);

        $result = $this->groupRepository->get($group->getId());

        $this->assertEquals($group, $result);
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Impossible to edit empty Fradoos\Domain\WorkingGroup.
     */
    public function testEditThrowErrorIfNull()
    {
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

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Impossible to get Fradoos\Domain\WorkingGroup with empty id.
     */
    public function testGetThrowErrorIfNull()
    {
        $this->groupRepository->get(null);
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorEntityNotFound
     * @expectedExceptionMessage Impossible to get Fradoos\Domain\WorkingGroup with id: 9999.
     */
    public function testThrowErrorIfIdNotExist()
    {
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

    protected function setUp()
    {
        parent::setUp();
        $this->groupRepository = new DoctrineRepositoryWorkingGroup($this->entityManager);
    }
}