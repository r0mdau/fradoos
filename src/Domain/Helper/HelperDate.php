<?php

namespace Fradoos\Domain\Helper;

use DateTime;
use DateTimeZone;
use Exception;
use Fradoos\Domain\Error\ErrorParameter;

class HelperDate
{
    const UI_FORMAT = "d/m/Y";
    const COMPUTE_FORMAT = "Ymd";
    const TIME_ZONE = 'Europe/Paris';

    /**
     * @param  $string string
     * @return DateTime|null
     * @throws ErrorParameter
     */
    public static function create($string)
    {
        $result = null;
        if (!empty($string)) {
            $result = DateTime::createFromFormat('Y-m-d', $string, new DateTimeZone(self::TIME_ZONE));
            if (!$result) {
                throw new ErrorParameter("La date '{$string}' ne respecte par le format suivant YYYY-MM-DD (ex: 2017-10-27)");
            }
            $result->setTime(0, 0, 0);
        }
        return $result;
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public static function now()
    {
        return new DateTime('now', new DateTimeZone(self::TIME_ZONE));
    }
}
