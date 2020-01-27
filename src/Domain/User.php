<?php

namespace Fradoos\Domain;

use Fradoos\Domain\Helper\HelperParameter;

/**
 * Class ApplicationUser
 *
 * @package App\Domain
 */
class User extends Entity
{
    /**
     * @var $name string
     */
    private $name;

    /**
     * ApplicationUser constructor.
     *
     * @param  $name
     * @throws Error\ErrorParameter
     */
    public function __construct($name)
    {
        $this->setName($name);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param  $name
     * @throws Error\ErrorParameter
     */
    public function setName($name)
    {
        HelperParameter::checkNotEmpty($name, "The user name is mandatory.");
        if ($this->name != $name) {
            $this->name = $name;
        }
    }
}