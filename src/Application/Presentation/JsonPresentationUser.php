<?php

namespace Fradoos\Application\Presentation;

use Fradoos\Domain\Presentation\IPresentation;
use Fradoos\Domain\User;

class JsonPresentationUser extends SimpleJsonPresentation implements IPresentation
{
    public static $id = 'id';
    public static $name = 'name';
    public static $email = 'email';

    public function __construct()
    {
        parent::__construct();

        $this->mappings[JsonPresentationUser::$name] = function (User $object) {
            return $object->getName();
        };
        $this->mappings[JsonPresentationUser::$email] = function (User $object) {
            return $object->getEmail();
        };
    }

    public function allDefaultProperties()
    {
        return [
            SimpleJsonPresentation::$id,
            JsonPresentationUser::$name,
            JsonPresentationUser::$email,
        ];
    }
}