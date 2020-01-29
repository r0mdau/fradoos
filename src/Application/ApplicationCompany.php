<?php

namespace Fradoos\Application;

use Fradoos\Domain\Helper\HelperParameter;
use Fradoos\Domain\Presentation\Presentations;
use Fradoos\Domain\Repository\Repositories;
use Fradoos\Domain\Company;

class ApplicationCompany extends HttpResources
{
    /**
     * @return ApplicationCompany
     */
    public static function instance()
    {
        return new ApplicationCompany();
    }

    /**
     * @SWG\Delete(
     *        path="/company/{id}", summary="Delete a company by id", description="",
     * @SWG\Parameter(name="id",   in="path", required=true, type="integer", description="Company id"),
     * @SWG\Response(response=204, description="")
     * )
     */
    public function delete($req, $res, $args)
    {
        Repositories::instance()->forCompany()->delete($args["id"]);

        return $this->response($res, static::STATUS_NO_CONTENT);
    }

    /**
     * @SWG\Get(
     *        path="/company/{id}", summary="Get a company by id", description="",
     * @SWG\Parameter(name="id",   in="path", required=true, type="integer", description="Company id"),
     * @SWG\Response(response=200, description="")
     * )
     */
    public function get($req, $res, $args)
    {
        $company = Repositories::instance()->forCompany()->get($args["id"]);

        return $this->response(
            $res, static::STATUS_OK,
            Presentations::instance()->forCompany()->inJsonWith(
                $company,
                HelperParameter::getFields($req->getParam("fields"))
            )
        );
    }

    /**
     * @SWG\Get(
     *        path="/company", summary="Get all companys", description="",
     * @SWG\Response(response=200, description="")
     * )
     */
    public function getAll($req, $res, $args)
    {
        $companys = Repositories::instance()->forCompany()->getAll();

        $presentation = Presentations::instance()->forCompany()->allInJsonWith(
            $companys,
            HelperParameter::getFields($req->getParam("fields"))
        );

        return $this->response($res, static::STATUS_OK, $presentation);
    }

    /**
     * @SWG\Post(
     *        path="/company", summary="Create a company", description="",
     * @SWG\Parameter(name="name", in="formData", required=true, type="string", description="Name"),
     * @SWG\Response(response=201, description="")
     * )
     */
    public function post($req, $res, $args)
    {
        $company = new Company($req->getParam("name"));
        Repositories::instance()->forCompany()->add($company);

        return $this->response(
            $res, static::STATUS_CREATED,
            Presentations::instance()->forCompany()->inJson($company)
        );
    }

    /**
     * @SWG\Put(
     *        path="/company/{id}", summary="Replace a company by id", description="",
     * @SWG\Parameter(name="id",    in="path", required=true, type="integer", description="Company id"),
     * @SWG\Parameter(name="name",  in="formData", required=true, type="string", description="Name"),
     * @SWG\Response(response=201,  description="")
     * )
     */
    public function put($req, $res, $args)
    {
        $presentation = "";
        $status = static::STATUS_NOT_FOUND;

        $company = Repositories::instance()->forCompany()->get($args["id"]);
        if (!is_null($company)) {
            $company->setName($req->getParam("name"));
            Repositories::instance()->forCompany()->edit($company);
            $presentation = Presentations::instance()->forCompany()->inJson($company);
            $status = static::STATUS_CREATED;
        }

        return $this->response($res, $status, $presentation);
    }
}