<?php

namespace Fradoos\Application\Presentation;

class JsonPresentationUserTest extends \PHPUnit\Framework\TestCase
{
    public function testToutesLesProprietesParDefaut()
    {
        $presentationUser = new JsonPresentationUser();
        $this->assertSame(
            ["id", "name", "email", "company"],
            $presentationUser->allDefaultProperties()
        );
    }
}