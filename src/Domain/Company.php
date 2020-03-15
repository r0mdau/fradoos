<?php

namespace Fradoos\Domain;

use Fradoos\Domain\Helper\HelperParameter;

/**
 * Class Company
 * @package Fradoos\Domain
 */
class Company extends Entity
{
    /**
     * @var $name string
     */
    private $name;

    /**
     * Company constructor.
     * @param $name
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
        HelperParameter::checkNotEmpty($name, "The company name is mandatory.");
        if ($this->name != $name) {
            $this->name = $name;
        }
    }
}