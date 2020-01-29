<?php

use Fradoos\Application\{ApplicationCompany, ApplicationUser, Swagger};

$id = "{id:\d+}";

$app->get("/api-docs", function ($req, $res, $args) {
    Swagger::instance()->getList($req, $res, $args);
});

$app->get("/company", function ($req, $res, $args) {return ApplicationCompany::instance()->getAll($req, $res, $args);});
$app->post("/company", function ($req, $res, $args) {return ApplicationCompany::instance()->post($req, $res, $args);});
$app->get("/company/$id", function ($req, $res, $args) {return ApplicationCompany::instance()->get($req, $res, $args);});
$app->put("/company/$id", function ($req, $res, $args) {return ApplicationCompany::instance()->put($req, $res, $args);});
$app->delete("/company/$id", function ($req, $res, $args) {return ApplicationCompany::instance()->delete($req, $res, $args);});

$app->get("/user", function ($req, $res, $args) {return ApplicationUser::instance()->getAll($req, $res, $args);});
$app->post("/user", function ($req, $res, $args) {return ApplicationUser::instance()->post($req, $res, $args);});
$app->get("/user/$id", function ($req, $res, $args) {return ApplicationUser::instance()->get($req, $res, $args);});
$app->put("/user/$id", function ($req, $res, $args) {return ApplicationUser::instance()->put($req, $res, $args);});
$app->delete("/user/$id", function ($req, $res, $args) {return ApplicationUser::instance()->delete($req, $res, $args);});
