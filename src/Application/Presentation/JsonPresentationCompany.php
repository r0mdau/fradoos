<?php

namespace Fradoos\Application\Presentation;

use Fradoos\Domain\Company;
use Fradoos\Domain\Presentation\IPresentation;

class JsonPresentationCompany extends SimpleJsonPresentation implements IPresentation
{
    public static $name = 'name';

    public function __construct()
    {
        parent::__construct();

        $this->mappings[JsonPresentationCompany::$name] = function (Company $object) {
            return $object->getName();
        };
    }

    public function allDefaultProperties()
    {
        return [
            SimpleJsonPresentation::$id,
            JsonPresentationCompany::$name,
        ];
    }
}