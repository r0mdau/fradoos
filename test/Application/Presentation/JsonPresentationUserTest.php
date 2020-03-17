<?php

namespace Fradoos\Application\Presentation;

class JsonPresentationUserTest extends \PHPUnit\Framework\TestCase
{
    public function testAllDefaultProperties()
    {
        $presentationUser = new JsonPresentationUser();
        $this->assertSame(
            ["id", "name", "email", "company", "workingGroups"],
            $presentationUser->allDefaultProperties()
        );
    }
}