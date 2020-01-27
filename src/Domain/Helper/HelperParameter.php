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
    public static function getFields($champs)
    {
        if (!is_null($champs)) {
            $champs = explode(',', $champs);
        }
        return $champs;
    }

    public static function checkEmail($email, $message)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new ErrorParameter(str_replace('$1', $email, $message));
        }
    }
    public static function checkNotEmpty($valeur, $message)
    {
        if (is_null($valeur) || '' === $valeur || [] === $valeur) {
            throw new ErrorParameter($message);
        }
    }
}