<?php

namespace Fradoos\Application;

class Swagger extends HttpResources
{
    public static function instance()
    {
        return new Swagger();
    }

    /**
     * @SWG\Get(
     *        path="/api-docs", summary="Documentation Swagger au format json", description="",
     * @SWG\Response(response=200, description="")
     * )
     */
    public function getList($req, $res, $args)
    {
        $swagger = \Swagger\scan(__DIR__);
        header('Content-Type: application/json');
        echo $swagger;
    }
}