<?php

namespace Fradoos\Domain\Presentation;

/**
 * Class Presentations
 * @package Fradoos\Domain\Presentation
 * @author Romain Dauby
 */
abstract class Presentations
{
    /**
     * @var
     */
    private static $_instance;

    /**
     * @param $instance
     */
    public static function initialize($instance)
    {
        static::$_instance = $instance;
    }

    /**
     * @return mixed
     */
    public static function instance()
    {
        return static::$_instance;
    }

    /**
     * @return mixed
     */
    abstract public function forUser();
}