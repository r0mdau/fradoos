<?php

namespace Fradoos\Application;

use Fradoos\Domain\Helper\HelperParameter;
use Fradoos\Domain\Presentation\Presentations;
use Fradoos\Domain\Repository\Repositories;
use Fradoos\Domain\WorkingGroup;

/**
 * Class ApplicationWorkingGroup
 * @package Fradoos\Application
 */
class ApplicationWorkingGroup extends HttpResources
{
    /**
     * @return ApplicationWorkingGroup
     */
    public static function instance()
    {
        return new ApplicationWorkingGroup();
    }

    /**
     * @SWG\Delete(
     *        path="/workingGroup/{id}", summary="Delete a workingGroup by id", description="",
     * @SWG\Parameter(name="id",   in="path", required=true, type="integer", description="WorkingGroup id"),
     * @SWG\Response(response=204, description="")
     * )
     */
    public function delete($req, $res, $args)
    {
        Repositories::instance()->forWorkingGroup()->delete($args["id"]);

        return $this->response($res, static::STATUS_NO_CONTENT);
    }

    /**
     * @SWG\Get(
     *        path="/workingGroup/{id}", summary="Get a workingGroup by id", description="",
     * @SWG\Parameter(name="id",   in="path", required=true, type="integer", description="WorkingGroup id"),
     * @SWG\Response(response=200, description="")
     * )
     */
    public function get($req, $res, $args)
    {
        $workingGroup = Repositories::instance()->forWorkingGroup()->get($args["id"]);

        return $this->response(
            $res, static::STATUS_OK,
            Presentations::instance()->forWorkingGroup()->inJsonWith(
                $workingGroup,
                HelperParameter::getFields($req->getParam("fields"))
            )
        );
    }

    /**
     * @SWG\Get(
     *        path="/workingGroup", summary="Get all workingGroups", description="",
     * @SWG\Response(response=200, description="")
     * )
     */
    public function getAll($req, $res, $args)
    {
        $workingGroups = Repositories::instance()->forWorkingGroup()->getAll();

        $presentation = Presentations::instance()->forWorkingGroup()->allInJsonWith(
            $workingGroups,
            HelperParameter::getFields($req->getParam("fields"))
        );

        return $this->response($res, static::STATUS_OK, $presentation);
    }

    /**
     * @SWG\Post(
     *        path="/workingGroup", summary="Create a workingGroup", description="",
     * @SWG\Parameter(name="name", in="formData", required=true, type="string", description="Name"),
     * @SWG\Response(response=201, description="")
     * )
     */
    public function post($req, $res, $args)
    {
        $workingGroup = new WorkingGroup($req->getParam("name"));
        Repositories::instance()->forWorkingGroup()->add($workingGroup);

        return $this->response(
            $res, static::STATUS_CREATED,
            Presentations::instance()->forWorkingGroup()->inJson($workingGroup)
        );
    }

    /**
     * @SWG\Put(
     *        path="/workingGroup/{id}", summary="Replace a workingGroup by id", description="",
     * @SWG\Parameter(name="id",    in="path", required=true, type="integer", description="WorkingGroup id"),
     * @SWG\Parameter(name="name",  in="formData", required=true, type="string", description="Name"),
     * @SWG\Response(response=201,  description="")
     * )
     */
    public function put($req, $res, $args)
    {
        $presentation = "";
        $status = static::STATUS_NOT_FOUND;

        $workingGroup = Repositories::instance()->forWorkingGroup()->get($args["id"]);
        if (!is_null($workingGroup)) {
            $workingGroup->setName($req->getParam("name"));
            Repositories::instance()->forWorkingGroup()->edit($workingGroup);
            $presentation = Presentations::instance()->forWorkingGroup()->inJson($workingGroup);
            $status = static::STATUS_CREATED;
        }

        return $this->response($res, $status, $presentation);
    }
}