<?php

namespace Fradoos\Application\Presentation;

use Fradoos\Domain\Presentation\IPresentation;
use Fradoos\Domain\Presentation\Presentations;
use Fradoos\Domain\User;

class JsonPresentationUser extends SimpleJsonPresentation implements IPresentation
{
    public static $name = 'name';
    public static $email = 'email';
    public static $company = 'company';
    public static $workingGroups = 'workingGroups';

    public function __construct()
    {
        parent::__construct();

        $this->mappings[JsonPresentationUser::$name] = function (User $object) {
            return $object->getName();
        };
        $this->mappings[JsonPresentationUser::$email] = function (User $object) {
            return $object->getEmail();
        };
        $this->mappings[JsonPresentationUser::$company] = function (User $object) {
            return is_null($object->getCompany()) ? "" : Presentations::instance()->forCompany()->inJson($object->getCompany());
        };
        $this->mappings[JsonPresentationUser::$workingGroups] = function (User $object) {
            return $object->getWorkingGroups()->isEmpty() ? "" : Presentations::instance()->forWorkingGroup()->allInJson($object->getWorkingGroups());
        };
    }

    public function allDefaultProperties()
    {
        return [
            SimpleJsonPresentation::$id,
            JsonPresentationUser::$name,
            JsonPresentationUser::$email,
            JsonPresentationUser::$company,
            JsonPresentationUser::$workingGroups,
        ];
    }
}