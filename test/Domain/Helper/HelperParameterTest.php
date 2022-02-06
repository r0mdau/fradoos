<?php

namespace Fradoos\Domain\Helper;

use Fradoos\Domain\Error\ErrorParameter;

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

    public function testCheckNonVideThrowErrorIfParametreVide()
    {
        $this->expectException(ErrorParameter::class);
        $this->expectExceptionMessage("Known error");

        HelperParameter::checkNotEmpty('', 'Known error');
    }

    public function testCheckNonVideThrowErrorIfParametreNull()
    {
        $this->expectException(ErrorParameter::class);
        $this->expectExceptionMessage("Still known error");

        HelperParameter::checkNotEmpty(null, 'Still known error');
    }

    public function testCheckNonVideThrowErrorIfParametreTableauVide()
    {
        $this->expectException(ErrorParameter::class);
        $this->expectExceptionMessage("Still known error");

        HelperParameter::checkNotEmpty(array(), 'Still known error');
        $this->assertFalse($this->hasExpectationOnOutput());
    }
}