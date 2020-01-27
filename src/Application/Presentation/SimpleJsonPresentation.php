<?php

namespace Fradoos\Application\Presentation;

use Fradoos\Domain\Presentation\IPresentation;

abstract class SimpleJsonPresentation extends JsonPresentation implements IPresentation
{
    public static $id = 'id';
    public static $libelle = 'libelle';

    public function __construct()
    {
        parent::__construct();
        $this->mappings[static::$id] = function ($objet) {
            return $objet->getId();
        };
        $this->mappings[static::$libelle] = function ($objet) {
            return $objet->getLibelle();
        };
    }

    public function allDefaultProperties()
    {
        return array(
            static::$id,
            static::$libelle
        );
    }
}