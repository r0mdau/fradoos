<?php

namespace Fradoos\Application;

use Fradoos\Domain\Repository\IRepositoryWorkingGroup;
use Fradoos\Domain\WorkingGroup;

class ApplicationWorkingGroupTest extends ApplicationTestCase
{
    private $workingGroupRepository;
    private $workingGroupMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->workingGroupRepository = $this->getMockBuilder(IRepositoryWorkingGroup::class)->getMock();
        $this->repository->expects($this->any())->method("forWorkingGroup")->willReturn($this->workingGroupRepository);
        $this->workingGroupMock = $this->getMockBuilder(WorkingGroup::class)->disableOriginalConstructor()->getMock();
    }

    public function testInstance()
    {
        $this->assertTrue(ApplicationWorkingGroup::instance() instanceof ApplicationWorkingGroup);
    }

    public function testDelete()
    {
        $this->workingGroupRepository->expects($this->once())->method('delete')->with('1');

        $this->client->delete('/workingGroup/1');

        $this->assertStatusEquals(204);
    }

    public function testGet()
    {
        $this->workingGroupRepository
            ->expects($this->once())
            ->method("get")
            ->with(1)
            ->willReturn($this->workingGroupMock);

        $this->client->get("/workingGroup/1");

        $this->assertStatusEquals(200);
        $this->assertResultEquals($this->workingGroupPresentation());
    }

    public function testGetAll()
    {
        $this->workingGroupRepository->expects($this->once())->method("getAll")->willReturn(
            [$this->workingGroupMock]
        );

        $this->client->get("/workingGroup");

        $this->assertStatusEquals(200);
        $this->assertResultEquals([$this->workingGroupPresentation()]);
    }

    public function testPost()
    {
        $this->workingGroupRepository
            ->expects($this->once())
            ->method("add")
            ->will($this->returnArgumentWithId());

        $this->client->post("/workingGroup", ["name" => "Super Inc."]);

        $this->assertStatusEquals(201);
        $this->assertResultEquals(["id" => 1, "name" => "Super Inc."]);
    }

    public function testPut()
    {
        $workingGroup = $this->getMockBuilder(WorkingGroup::class)->disableOriginalConstructor()->getMock();
        $workingGroup->expects($this->once())->method("setName")->with("Super Inc.");
        $workingGroup->expects($this->once())->method("getId")->willReturn(1);
        $workingGroup->expects($this->once())->method("getName")->willReturn("Super Inc.");

        $this->workingGroupRepository
            ->expects($this->once())
            ->method("get")
            ->with(1)
            ->willReturn($workingGroup);
        $this->workingGroupRepository
            ->expects($this->once())
            ->method("edit")
            ->with($workingGroup);

        $this->client->put("/workingGroup/1", ["name" => "Super Inc."]);

        $this->assertStatusEquals(201);
        $this->assertResultEquals(["id" => 1, "name" => "Super Inc."]);
    }

    private function workingGroupPresentation()
    {
        return [
            "id" => null,
            "name" => null
        ];
    }
}