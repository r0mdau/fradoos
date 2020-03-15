<?php

namespace Fradoos\Application\Presentation;

use Fradoos\Domain\Presentation\IPresentation;
use Fradoos\Domain\WorkingGroup;

class JsonPresentationWorkingGroup extends SimpleJsonPresentation implements IPresentation
{
    public static $name = 'name';

    public function __construct()
    {
        parent::__construct();

        $this->mappings[JsonPresentationWorkingGroup::$name] = function (WorkingGroup $object) {
            return $object->getName();
        };
    }

    public function allDefaultProperties()
    {
        return [
            SimpleJsonPresentation::$id,
            JsonPresentationWorkingGroup::$name,
        ];
    }
}