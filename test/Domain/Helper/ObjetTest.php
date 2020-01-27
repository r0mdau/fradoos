<?php

namespace Fradoos\Domaine;

use Fradoos\Domain\Helper\HelperObject;

class ObjetTest extends \PHPUnit\Framework\TestCase
{
    public function testModifierProprietePrivee()
    {
        $objet = new ObjetDeTest(8);
        HelperObject::editPrivateProperty('propriete', 10, $objet);
        $this->assertEquals(10, $objet->getPropriete());
    }
}

class ObjetDeTest
{
    private $propriete;

    public function __construct($value)
    {
        $this->propriete = $value;
    }

    public function getPropriete()
    {
        return $this->propriete;
    }
}