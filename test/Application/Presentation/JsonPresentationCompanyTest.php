<?php

namespace Fradoos\Application\Presentation;

class JsonPresentationCompanyTest extends \PHPUnit\Framework\TestCase
{
    public function testToutesLesProprietesParDefaut()
    {
        $presentationCompany = new JsonPresentationCompany();
        $this->assertSame(
            ["id", "name"],
            $presentationCompany->allDefaultProperties()
        );
    }
}