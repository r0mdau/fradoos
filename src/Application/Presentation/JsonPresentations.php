<?php

namespace Fradoos\Application\Presentation;

use Fradoos\Domain\Presentation\Presentations;

class JsonPresentations extends Presentations
{
    /**
     * @return JsonPresentationUser
     */
    public function forUser()
    {
        return new JsonPresentationUser();
    }

    /**
     * @return JsonPresentationCompany
     */
    public function forCompany()
    {
        return new JsonPresentationCompany();
    }

    /**
     * @return JsonPresentationWorkingGroup
     */
    public function forWorkingGroup()
    {
        return new JsonPresentationWorkingGroup();
    }
}