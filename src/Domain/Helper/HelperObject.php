<?php

namespace Fradoos\Domain\Helper;

class HelperObject
{
    public static function getClassName($entity)
    {
        $class = new \ReflectionClass(get_class($entity));
        return $class->getShortName();
    }

    public static function editPrivateProperty($member, $value, $object)
    {
        $reflectionClass = new \ReflectionClass($object);
        $reflectionProperty = $reflectionClass->getProperty($member);
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($object, $value);
        return $object;
    }
}