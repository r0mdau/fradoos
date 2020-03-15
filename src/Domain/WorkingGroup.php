<?php

namespace Fradoos\Domain;

use Fradoos\Domain\Helper\HelperParameter;

/**
 * Class WorkingGroup
 * @package Fradoos\Domain
 */
class WorkingGroup extends Entity
{
    /**
     * @var $name string
     */
    private $name;

    /**
     * WorkingGroup constructor.
     * @param $name
     * @param $email
     * @throws Error\ErrorParameter
     */
    public function __construct($name)
    {
        $this->setName($name);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param  $name
     * @throws Error\ErrorParameter
     */
    public function setName(string $name)
    {
        HelperParameter::checkNotEmpty($name, "The workingGroup name is mandatory.");
        if ($this->name != $name) {
            $this->name = $name;
        }
    }
}