<?php

namespace Fradoos\Application\Presentation;

class JsonPresentationsTest extends \PHPUnit\Framework\TestCase
{
    public function testForCompany()
    {
        $presentation = new JsonPresentations();
        $this->assertInstanceOf(JsonPresentationCompany::class, $presentation->forCompany());
    }

    public function testForUser()
    {
        $presentation = new JsonPresentations();
        $this->assertInstanceOf(JsonPresentationUser::class, $presentation->forUser());
    }

    public function testForWorkingGroup()
    {
        $presentation = new JsonPresentations();
        $this->assertInstanceOf(JsonPresentationWorkingGroup::class, $presentation->forWorkingGroup());
    }
}