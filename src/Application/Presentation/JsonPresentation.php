<?php

namespace Fradoos\Application\Presentation;

/**
 * Class JsonPresentation
 * @package Fradoos\Application\Presentation
 */
abstract class JsonPresentation
{
    /**
     * @var array
     */
    protected $mappings;

    /**
     * JsonPresentation constructor.
     */
    public function __construct()
    {
        $this->mappings = [];
    }

    /**
     * @param $objects
     * @param $properties
     * @return array
     */
    public function allInJsonWith($objects, $properties)
    {
        if (is_null($properties) || empty($properties)) {
            return $this->allInJson($objects);
        }
        $map = [];
        if (!is_null($objects)) {
            foreach ($objects as $object) {
                $map[] = $this->inJsonWith($object, $properties);
            }
        }
        return $map;
    }

    /**
     * @param $objects
     * @return array
     */
    public function allInJson($objects)
    {
        $map = [];
        if (!is_null($objects)) {
            foreach ($objects as $object) {
                $map[] = $this->inJson($object);
            }
        }
        return $map;
    }

    /**
     * @param $object
     * @return array|null
     */
    public function inJson($object)
    {
        return is_null($object) ? null : $this->inJsonWith(
            $object,
            $this->allDefaultProperties()
        );
    }

    /**
     * @param $object
     * @param $properties
     * @return array
     */
    public function inJsonWith($object, $properties)
    {
        $result = [];
        foreach ($properties as $property) {
            $result[$property] = "";
            if (array_key_exists($property, $this->mappings) && !is_null($object)) {
                $result[$property] = $this->mappings[$property]($object);
            }
        }
        return $result;
    }

    /**
     * @return mixed
     */
    abstract function allDefaultProperties();
}
