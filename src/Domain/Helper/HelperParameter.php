<?php

namespace Fradoos\Domain\Helper;

use Fradoos\Domain\Error\ErrorParameter;

/**
 * Class HelperParameter
 *
 * @package Fradoos\Domain\Helper
 */
abstract class HelperParameter
{
    public static function formatDate($valeur)
    {
        $date = \DateTime::createFromFormat('d/m/Y', $valeur);
        if ($date !== false) {
            $date->setTime(0, 0, 0);
        } else {
            throw new ErrorParameter("Le format de date n'est pas valide : $valeur, attendu : 01/01/2016");
        }
        return $date === false ? $valeur : $date;
    }

    public static function formatFloat($valeur)
    {
        if (!is_null($valeur) && is_numeric($valeur)) {
            $valeurFormate = $valeur;
            return settype($valeurFormate, 'float') ? $valeurFormate : $valeur;
        }
        return $valeur;
    }

    public static function formatInteger($valeur)
    {
        if (!is_null($valeur) && is_numeric($valeur)) {
            $valeurFormate = $valeur;
            return settype($valeurFormate, 'integer') ? $valeurFormate : $valeur;
        }
        return $valeur;
    }

    public static function convertYesNoStringToBoolean($valeur)
    {
        if (!is_null($valeur)) {
            if ($valeur === 'Oui') {
                $valeur = true;
            } else if ($valeur === 'Non') {
                $valeur = false;
            }
        }
        return $valeur;
    }

    public static function getFields($champs)
    {
        if (!is_null($champs)) {
            $champs = explode(',', $champs);
        }
        return $champs;
    }

    public static function checkBoolean($valeur, $message)
    {
        if (!is_null($valeur) && !is_bool($valeur)) {
            throw new ErrorParameter(str_replace('$1', $valeur, $message));
        }
    }

    public static function checkDate($valeur, $message)
    {
        if (!is_null($valeur) && !($valeur instanceof \DateTime)) {
            throw new ErrorParameter(str_replace('$1', $valeur, $message));
        }
    }

    public static function checkFloat($valeur, $message)
    {
        if (!is_null($valeur) && !is_numeric($valeur)) {
            throw new ErrorParameter(str_replace('$1', $valeur, $message));
        }
    }

    public static function checkEmail($email, $message)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new ErrorParameter(str_replace('$1', $email, $message));
        }
    }

    public static function checkInteger($valeur, $message)
    {
        if (!is_null($valeur) && !is_integer($valeur)) {
            throw new ErrorParameter(str_replace('$1', $valeur, $message));
        }
    }

    public static function checkEnumeration($valeur, array $valeurs, $message)
    {
        if (!is_null($valeur) && !in_array($valeur, $valeurs)) {
            throw new ErrorParameter(str_replace('$1', $valeur, $message));
        }
    }

    public static function checkFormat($format, $valeur, $message)
    {
        if (!preg_match("#$format#", $valeur)) {
            throw new ErrorParameter(str_replace('$1', $valeur, $message));
        }
    }

    public static function checkNotEmpty($valeur, $message)
    {
        if (is_null($valeur) || '' === $valeur || [] === $valeur) {
            throw new ErrorParameter($message);
        }
    }
}