<?php

use Fradoos\Application\HttpResources;
use Fradoos\Domain\Error\ErrorEntityAlreadyExist;
use Fradoos\Domain\Error\ErrorEntityNotEditable;
use Fradoos\Domain\Error\ErrorEntityNotFound;
use Fradoos\Domain\Error\ErrorParameter;
use Fradoos\Domain\Repository\Repositories;

$app->add(
    function ($request, $response, $next) use ($app) {
        try {
            Repositories::instance()->beginTransaction();

            $response = $next($request, $response);

            $app->getContainer()->get("logger")->info(
                "{$response->getStatusCode()} {$request->getMethod()} {$request->getUri()}"
            );

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

            $label = new \ReflectionClass($e);
            $status = array_key_exists($label->getName(), $map) ? $map[$label->getName()] : 500;

            $app->getContainer()->get("logger")->error(
                "{$status} {$request->getMethod()} {$request->getUri()}, message: {$e->getMessage()}"
            );
            Repositories::instance()->rollback();

            $response = $response
                ->withStatus($status)
                ->withHeader("Content-Type", "application/json")
                ->write(json_encode(["error" => $e->getMessage()]));
        }
        return $response;
    }
);