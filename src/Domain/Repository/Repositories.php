<?php

namespace Fradoos\Domain\Repository;

abstract class Repositories
{
    private static $_instance;

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

    abstract public function forUser();

    abstract public function forCompany();

    abstract public function forWorkingGroup();

    abstract public function beginTransaction();

    abstract public function rollback();

    abstract public function commit();
}