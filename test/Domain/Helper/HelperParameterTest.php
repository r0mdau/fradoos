<?php

namespace Fradoos\Domain\Helper;

class HelperParameterTest extends \PHPUnit\Framework\TestCase
{
    public function testGetFieldsReturnNullIfFieldsNull()
    {
        $this->assertNull(HelperParameter::getFields(null));
    }

    public function testGetFieldsReturnVideIfFieldsEmpty()
    {
        $this->assertEquals(array(''), HelperParameter::getFields(''));
    }

    public function testRecupererChamps()
    {
        $this->assertEquals(array('id', 'nom', 'prenom'), HelperParameter::getFields('id,nom,prenom'));
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Erreur connue
     */
    public function testCheckNonVideThrowErrorIfParametreVide()
    {
        HelperParameter::checkNotEmpty('', 'Erreur connue');
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Erreur encore connue
     */
    public function testCheckNonVideThrowErrorIfParametreNull()
    {
        HelperParameter::checkNotEmpty(null, 'Erreur encore connue');
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Erreur encore connue
     */
    public function testCheckNonVideThrowErrorIfParametreTableauVide()
    {
        HelperParameter::checkNotEmpty(array(), 'Erreur encore connue');
        $this->assertFalse($this->hasExpectationOnOutput());
    }
}