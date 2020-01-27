<?php

namespace Fradoos\Domain\Helper;

class ParameterCheckerTest extends \PHPUnit\Framework\TestCase
{
    public function testFormatDate()
    {
        $date = '15/09/2015';
        $datetime = \DateTime::createFromFormat('d/m/Y', $date);
        $datetime->setTime(0, 0, 0);
        $this->assertEquals($datetime, HelperParameter::formatDate($date));
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Le format de date n'est pas valide : absurde, attendu : 01/01/2016
     */
    public function testFormaterDateThrowErrorIfFalse()
    {
        HelperParameter::formatDate('absurde');
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Le format de date n'est pas valide : , attendu : 01/01/2016
     */
    public function testFormaterDateThrowErrorIfNull()
    {
        HelperParameter::formatDate(null);
    }

    public function testFormaterDecimal()
    {
        $this->assertSame(1.10, HelperParameter::formatFloat(1.10));
        $this->assertSame(20.0, HelperParameter::formatFloat(20));
    }

    public function testFormaterDecimalRetournValeurIfFalse()
    {
        $this->assertNull(HelperParameter::formatFloat(null));
        $this->assertSame('', HelperParameter::formatFloat(''));
        $this->assertSame('absurde', HelperParameter::formatFloat('absurde'));
        $this->assertTrue(HelperParameter::formatFloat(true));
    }

    public function testFormaterEntier()
    {
        $this->assertSame(32000, HelperParameter::formatInteger("32000"));
        $this->assertSame(11, HelperParameter::formatInteger(11));
    }

    public function testFormaterEntierRetournValeurIfFalse()
    {
        $this->assertNull(HelperParameter::formatInteger(null));
        $this->assertSame('', HelperParameter::formatInteger(''));
        $this->assertSame('absurde', HelperParameter::formatInteger('absurde'));
        $this->assertTrue(HelperParameter::formatInteger(true));
    }

    public function testFormaterOuiNonBooleen()
    {
        $this->assertNull(HelperParameter::convertYesNoStringToBoolean(null));
        $this->assertEquals('', HelperParameter::convertYesNoStringToBoolean(''));
        $this->assertEquals('coucou', HelperParameter::convertYesNoStringToBoolean('coucou'));
        $this->assertTrue(HelperParameter::convertYesNoStringToBoolean('Oui'));
        $this->assertFalse(HelperParameter::convertYesNoStringToBoolean('Non'));
    }

    public function testRecupererChampsRetourneNullIfChampsNull()
    {
        $this->assertNull(HelperParameter::getFields(null));
    }

    public function testRecupererChampsRetourneVideIfChampsVides()
    {
        $this->assertEquals(array(''), HelperParameter::getFields(''));
    }

    public function testRecupererChamps()
    {
        $this->assertEquals(array('id', 'nom', 'prenom'), HelperParameter::getFields('id,nom,prenom'));
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Une erreur faux
     */
    public function testCheckBooleenThrowErrorIfString()
    {
        HelperParameter::checkBoolean('faux', "Une erreur $1");
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Une erreur 10
     */
    public function testCheckBooleenThrowErrorIfEntier()
    {
        HelperParameter::checkBoolean(10, "Une erreur $1");
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Une erreur 1
     */
    public function testCheckBooleenNotThrowErrorIfDecimal()
    {
        HelperParameter::checkBoolean(10.56, "Une erreur $1");
    }

    public function testCheckBooleenNotThrowErrorIfNull()
    {
        HelperParameter::checkBoolean(null, "Une erreur $1");
        $this->assertFalse($this->hasExpectationOnOutput());
    }

    public function testCheckBooleenNotThrowErrorIfBooleen()
    {
        HelperParameter::checkBoolean(true, "Une erreur $1");
        $this->assertFalse($this->hasExpectationOnOutput());
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage faux
     */
    public function testCheckDateThrowErrorIfFalse()
    {
        HelperParameter::checkDate("test", "faux");
    }

    public function testCheckDateNotThrowErrorIfDate()
    {
        $date = new \DateTime();
        HelperParameter::checkDate($date, "coucou");
        $this->assertFalse($this->hasExpectationOnOutput());
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Une erreur faux
     */
    public function testCheckFloatThrowErrorIfString()
    {
        HelperParameter::checkFloat('faux', "Une erreur $1");
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Une erreur 1
     */
    public function testCheckFloatThrowErrorIfBooleen()
    {
        HelperParameter::checkFloat(true, "Une erreur $1");
    }

    public function testCheckFloatNotThrowErrorIfDecimal()
    {
        HelperParameter::checkFloat(10.56, "Une erreur $1");
        $this->assertFalse($this->hasExpectationOnOutput());
    }

    public function testCheckFloatNotThrowErrorIfNull()
    {
        HelperParameter::checkFloat(null, "Une erreur $1");
        $this->assertFalse($this->hasExpectationOnOutput());
    }

    public function testCheckFloatNotThrowErrorIfEntier()
    {
        HelperParameter::checkFloat(10, "Une erreur $1");
        $this->assertFalse($this->hasExpectationOnOutput());
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Une erreur 10
     */
    public function testCheckEntierThrowErrorIfString()
    {
        HelperParameter::checkInteger('10', "Une erreur $1");
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Une erreur 1
     */
    public function testCheckEntierThrowErrorIfBooleen()
    {
        HelperParameter::checkInteger(true, "Une erreur $1");
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Une erreur 10.56
     */
    public function testCheckEntierThrowErrorIfDecimal()
    {
        HelperParameter::checkInteger(10.56, "Une erreur $1");
    }

    public function testCheckEntierNotThrowErrorIfNull()
    {
        HelperParameter::checkInteger(null, "Une erreur $1");
        $this->assertFalse($this->hasExpectationOnOutput());
    }

    public function testCheckEntierNotThrowErrorIfEntier()
    {
        HelperParameter::checkInteger(10, "Une erreur $1");
        $this->assertFalse($this->hasExpectationOnOutput());
    }

    /**
     * @expectedException \Fradoos\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Une erreur 10
     */
    public function testCheckEnumerationThrowErrorIfVariableAppartientPasALaListe()
    {
        HelperParameter::checkEnumeration('10', ['11', '12'], "Une erreur $1");
    }

    public function testCheckEnumerationNotThrowErrorIfVariableAppartientALaListe()
    {
        HelperParameter::checkEnumeration('5', ['10', '12', '5'], "Une erreur");
        $this->assertFalse($this->hasExpectationOnOutput());
    }

    public function testCheckEnumerationNotThrowErrorIfVariableNull()
    {
        HelperParameter::checkEnumeration(null, ['10', '12', '5'], "Une erreur");
        $this->assertFalse($this->hasExpectationOnOutput());
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

    public function testCheckNonVideNotThrowErrorIfParametreChaineNonVide()
    {
        HelperParameter::checkNotEmpty('parametre non vide', 'Une autre erreur');
        $this->assertFalse($this->hasExpectationOnOutput());
    }

    public function testCheckNonVideNotThrowErrorIfParametreZero()
    {
        HelperParameter::checkNotEmpty(0, 'Encore une autre erreur');
        $this->assertFalse($this->hasExpectationOnOutput());
    }
}