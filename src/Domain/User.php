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
     * @var $email string
     */
    private $email;

    /**
     * @var $company null|Company
     */
    private $company;

    /**
     * ApplicationUser constructor.
     *
     * @param  $name string
     * @param $email string
     * @throws Error\ErrorParameter
     */
    public function __construct($name, $email)
    {
        $this->setName($name);
        $this->setEmail($email);
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
        HelperParameter::checkNotEmpty($name, "The user name is mandatory.");
        if ($this->name != $name) {
            $this->name = $name;
        }
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @throws Error\ErrorParameter
     */
    public function setEmail(string $email)
    {
        HelperParameter::checkNotEmpty($email, "The user email is mandatory.");
        HelperParameter::checkEmail($email, "The user email is not well formatted: '$1'.");
        if ($this->email != $email) {
            $this->email = $email;
        }
    }

    /**
     * @return Company|null
     */
    public function getCompany(): ?Company
    {
        return $this->company;
    }

    /**
     * @param Company|null $company
     */
    public function setCompany(?Company $company)
    {
        if ($this->company !== $company) {
            $this->company = $company;
        }
    }
}