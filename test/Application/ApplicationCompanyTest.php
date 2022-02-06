<?php

namespace Fradoos\Application;

use Fradoos\Domain\Company;
use Fradoos\Domain\Repository\IRepositoryCompany;

class ApplicationCompanyTest extends ApplicationTestCase
{
    private $companyRepository;
    private $companyMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->companyRepository = $this->getMockBuilder(IRepositoryCompany::class)->getMock();
        $this->repository->expects($this->any())->method("forCompany")->willReturn($this->companyRepository);
        $this->companyMock = $this->getMockBuilder(Company::class)->disableOriginalConstructor()->getMock();
    }

    public function testInstance()
    {
        $this->assertTrue(ApplicationCompany::instance() instanceof ApplicationCompany);
    }

    public function testDelete()
    {
        $this->companyRepository->expects($this->once())->method('delete')->with('1');

        $this->client->delete('/company/1');

        $this->assertStatusEquals(204);
    }

    public function testGet()
    {
        $this->companyRepository
            ->expects($this->once())
            ->method("get")
            ->with(1)
            ->willReturn($this->companyMock);

        $this->client->get("/company/1");

        $this->assertStatusEquals(200);
        $this->assertResultEquals($this->companyPresentation());
    }

    public function testGetAll()
    {
        $this->companyRepository->expects($this->once())->method("getAll")->willReturn(
            [$this->companyMock]
        );

        $this->client->get("/company");

        $this->assertStatusEquals(200);
        $this->assertResultEquals([$this->companyPresentation()]);
    }

    public function testPost()
    {
        $this->companyRepository
            ->expects($this->once())
            ->method("add")
            ->will($this->returnArgumentWithId());

        $this->client->post("/company", ["name" => "Super Inc."]);

        $this->assertStatusEquals(201);
        $this->assertResultEquals(["id" => 1, "name" => "Super Inc."]);
    }

    public function testPut()
    {
        $company = $this->getMockBuilder(Company::class)->disableOriginalConstructor()->getMock();
        $company->expects($this->once())->method("setName")->with("Super Inc.");
        $company->expects($this->once())->method("getId")->willReturn(1);
        $company->expects($this->once())->method("getName")->willReturn("Super Inc.");

        $this->companyRepository
            ->expects($this->once())
            ->method("get")
            ->with(1)
            ->willReturn($company);
        $this->companyRepository
            ->expects($this->once())
            ->method("edit")
            ->with($company);

        $this->client->put("/company/1", ["name" => "Super Inc."]);

        $this->assertStatusEquals(201);
        $this->assertResultEquals(["id" => 1, "name" => "Super Inc."]);
    }

    private function companyPresentation()
    {
        return [
            "id" => null,
            "name" => null
        ];
    }
}