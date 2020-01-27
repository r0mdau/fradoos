<?php

namespace Fradoos\Application;

use Fradoos\Domain\Helper\HelperParameter;
use Fradoos\Domain\Presentation\Presentations;
use Fradoos\Domain\Repository\Repositories;
use Fradoos\Domain\User;

class ApplicationUser extends HttpResources
{
    /**
     * @return ApplicationUser
     */
    public static function instance()
    {
        return new ApplicationUser();
    }

    /**
     * @SWG\Delete(
     *        path="/user/{id}", summary="Delete a user by id", description="",
     * @SWG\Parameter(name="id",   in="path", required=true, type="integer", description="User id"),
     * @SWG\Response(response=204, description="")
     * )
     */
    public function delete($req, $res, $args)
    {
        Repositories::instance()->forUser()->delete($args["id"]);

        return $this->response($res, static::STATUS_NO_CONTENT);
    }

    /**
     * @SWG\Get(
     *        path="/user/{id}", summary="Get a user by id", description="",
     * @SWG\Parameter(name="id",   in="path", required=true, type="integer", description="User id"),
     * @SWG\Response(response=200, description="")
     * )
     */
    public function get($req, $res, $args)
    {
        $user = Repositories::instance()->forUser()->get($args["id"]);

        return $this->response(
            $res, static::STATUS_OK,
            Presentations::instance()->forUser()->inJson($user)
        );
    }

    /**
     * @SWG\Get(
     *        path="/user", summary="Get all users", description="",
     * @SWG\Response(response=200, description="")
     * )
     */
    public function getAll($req, $res, $args)
    {
        $users = Repositories::instance()->forUser()->getAll();

        $representation = Presentations::instance()->forUser()->allInJsonWith(
            $users,
            HelperParameter::getFields($req->getParam("fields"))
        );

        return $this->response($res, static::STATUS_OK, $representation);
    }

    /**
     * @SWG\Post(
     *        path="/user", summary="Create a user", description="",
     * @SWG\Parameter(name="name", in="formData", required=true, type="string", description="Name"),
     * @SWG\Response(response=201, description="")
     * )
     */
    public function post($req, $res, $args)
    {
        $name = $req->getParam("name");

        $user = new User($name);
        Repositories::instance()->forUser()->add($user);

        return $this->response(
            $res, static::STATUS_CREATED,
            Presentations::instance()->forUser()->inJson($user)
        );
    }

    /**
     * @SWG\Put(
     *        path="/user/{id}", summary="Replace a user by id", description="",
     * @SWG\Parameter(name="id",    in="path", required=true, type="integer", description="User id"),
     * @SWG\Parameter(name="name",  in="formData", required=true, type="string", description="Name"),
     * @SWG\Parameter(name="email", in="formData", required=true, type="string", description="Email"),
     * @SWG\Response(response=201,  description="")
     * )
     */
    public function put($req, $res, $args)
    {
        $representation = "";
        $status = static::STATUS_NOT_FOUND;

        $user = Repositories::instance()->forUser()->get($args["id"]);
        if (!is_null($user)) {
            $user->setName($req->getParam("name"));
            Repositories::instance()->forUser()->edit($user);
            $representation = Presentations::instance()->forUser()->inJson($user);
            $status = static::STATUS_CREATED;
        }

        return $this->response($res, $status, $representation);
    }
}