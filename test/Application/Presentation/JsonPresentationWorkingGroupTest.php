<?php

namespace Fradoos\Application\Presentation;

class JsonPresentationWorkingGroupTest extends \PHPUnit\Framework\TestCase
{
    public function testAllDefaultProperties()
    {
        $presentationWorkingGroup = new JsonPresentationWorkingGroup();
        $this->assertSame(
            ["id", "name"],
            $presentationWorkingGroup->allDefaultProperties()
        );
    }
}