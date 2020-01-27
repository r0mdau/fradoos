<?php

namespace Fradoos\Domaine;

use Fradoos\Domain\Helper\HelperObject;

class HelperObjectTest extends \PHPUnit\Framework\TestCase
{
    public function testModifierProprietePrivee()
    {
        $objet = new ObjectForTest(8);
        HelperObject::editPrivateProperty('property', 10, $objet);
        $this->assertEquals(10, $objet->getProperty());
    }
}

class ObjectForTest
{
    private $property;

    public function __construct($value)
    {
        $this->property = $value;
    }

    public function getProperty()
    {
        return $this->property;
    }
}