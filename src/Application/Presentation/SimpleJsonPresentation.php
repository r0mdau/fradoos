<?php

namespace Fradoos\Application\Presentation;

use Fradoos\Domain\Presentation\IPresentation;

abstract class SimpleJsonPresentation extends JsonPresentation implements IPresentation
{
    public static $id = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->mappings[static::$id] = function ($objet) {
            return $objet->getId();
        };
    }

    public function allDefaultProperties()
    {
        return [static::$id];
    }
}