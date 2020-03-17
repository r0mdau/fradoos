<?php

namespace Fradoos\Application\Presentation;

use Fradoos\Domain\Presentation\Presentations;

class JsonPresentations extends Presentations
{
    /**
     * @return JsonPresentationCompany
     */
    public function forCompany()
    {
        return new JsonPresentationCompany();
    }

    /**
     * @return JsonPresentationUser
     */
    public function forUser()
    {
        return new JsonPresentationUser();
    }

    /**
     * @return JsonPresentationWorkingGroup
     */
    public function forWorkingGroup()
    {
        return new JsonPresentationWorkingGroup();
    }
}