<?php

namespace Fradoos\Application\Presentation;

class JsonPresentationUserTest extends \PHPUnit\Framework\TestCase
{
    public function testToutesLesProprietesParDefaut()
    {
        $representationDirection = new JsonPresentationUser();
        $this->assertSame(
            ["id", "name", "email"],
            $representationDirection->allDefaultProperties()
        );
    }
}