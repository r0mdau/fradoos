<?php

namespace Fradoos\Infrastructure;

class Configuration
{
    private static $_configuration;

    public static function init(array $configuration)
    {
        static::$_configuration = $configuration;
    }

    public static function get($key = null)
    {
        return is_null($key) ? static::$_configuration : static::$_configuration[$key];
    }
}