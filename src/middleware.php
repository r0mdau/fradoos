<?php

use Fradoos\Application\HttpResources;
use Fradoos\Domain\Error\ErrorEntityAlreadyExist;
use Fradoos\Domain\Error\ErrorEntityNotEditable;
use Fradoos\Domain\Error\ErrorEntityNotFound;
use Fradoos\Domain\Error\ErrorParameter;
use Fradoos\Domain\Repository\Repositories;

//use Fradoos\Infrastructure\MessageLog;

$app->add(
    function ($request, $response, $next) use ($app) {
        try {
            Repositories::instance()->beginTransaction();

            $response = $next($request, $response);

            //$app->getContainer()->get("logger")->info(MessageLog::succes($app->getContainer()));
            if (in_array($request->getMethod(), ["POST", "PUT", "DELETE", "PATCH"])) {
                Repositories::instance()->commit();
            }
        } catch (\Exception $e) {
            $map = [
                ErrorEntityNotFound::class => HttpResources::STATUS_NOT_FOUND,
                ErrorParameter::class => HttpResources::STATUS_BAD_REQUEST,
                ErrorEntityNotEditable::class => HttpResources::STATUS_FORBIDDEN,
                ErrorEntityAlreadyExist::class => HttpResources::STATUS_BAD_REQUEST,
            ];

            $libelle = new \ReflectionClass($e);
            $statut = array_key_exists($libelle->getName(), $map) ? $map[$libelle->getName()] : 500;

            //$app->getContainer()->get("logger")->error(MessageLog::erreur($app->getContainer(), $statut, $e->getMessage()));
            Repositories::instance()->rollback();

            $response = $response
                ->withStatus($statut)
                ->withHeader("Content-Type", "application/json")
                ->write(json_encode(["erreur" => $e->getMessage()]));
        }
        return $response;
    }
);