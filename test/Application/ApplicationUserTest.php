<?php

namespace Fradoos\Application;

use Doctrine\Common\Collections\ArrayCollection;
use Fradoos\Domain\Repository\IRepositoryUser;
use Fradoos\Domain\User;

class ApplicationUserTest extends ApplicationTestCase
{
    private $userRepository;
    private $userMock;

    public function setUp()
    {
        parent::setUp();
        $this->userRepository = $this->getMockBuilder(IRepositoryUser::class)->getMock();
        $this->repository->expects($this->any())->method("forUser")->willReturn($this->userRepository);
        $this->userMock = $this->getMockBuilder(User::class)->disableOriginalConstructor()->getMock();
        $this->userMock->expects($this->any())->method("setName")->with("Georges V");
        $this->userMock->expects($this->any())->method("setEmail")->with("test@example.com");
        $this->userMock->expects($this->any())->method("getId")->willReturn(1);
        $this->userMock->expects($this->any())->method("getName")->willReturn("Georges V");
        $this->userMock->expects($this->any())->method("getEmail")->willReturn("test@example.com");
        $this->userMock->expects($this->any())->method("getWorkingGroups")->willReturn(new ArrayCollection());
    }

    public function testInstance()
    {
        $this->assertTrue(ApplicationUser::instance() instanceof ApplicationUser);
    }

    public function testDelete()
    {
        $this->userRepository->expects($this->once())->method('delete')->with('1');

        $this->client->delete('/user/1');

        $this->assertStatusEquals(204);
    }

    public function testGet()
    {
        $this->userRepository
            ->expects($this->once())
            ->method("get")
            ->with(1)
            ->willReturn($this->userMock);

        $this->client->get("/user/1");

        $this->assertStatusEquals(200);
        $this->assertResultEquals($this->userPresentation());
    }

    public function testGetAll()
    {
        $this->userRepository->expects($this->once())->method("getAll")->willReturn(
            [$this->userMock]
        );

        $this->client->get("/user");

        $this->assertStatusEquals(200);
        $this->assertResultEquals([$this->userPresentation()]);
    }

    public function testPost()
    {
        $this->userRepository
            ->expects($this->once())
            ->method("add")
            ->will($this->returnArgumentWithId());

        $this->client->post("/user", ["name" => "Georges V", "email" => "test@example.com"]);

        $this->assertStatusEquals(201);
        $this->assertResultEquals($this->userPresentation());
    }

    public function testPut()
    {
        $this->userRepository
            ->expects($this->once())
            ->method("get")
            ->with(1)
            ->willReturn($this->userMock);
        $this->userRepository
            ->expects($this->once())
            ->method("edit")
            ->with($this->userMock);

        $this->client->put("/user/1", ["name" => "Georges V", "email" => "test@example.com"]);

        $this->assertStatusEquals(201);
        $this->assertResultEquals($this->userPresentation());
    }

    private function userPresentation()
    {
        return [
            "id" => 1,
            "name" => "Georges V",
            "email" => "test@example.com",
            "company" => "",
            "workingGroups" => ""
        ];
    }
}