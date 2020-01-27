<?php

require_once __DIR__ . "/../vendor/autoload.php";

$app = new \Slim\App();

$env = $_SERVER["APP_ENV"] ?? "development";
$configuration = parse_ini_file(__DIR__ . "/../config/application.$env.ini", true);

require_once __DIR__ . "/../src/dependencies.php";
require_once __DIR__ . "/../src/middleware.php";
require_once __DIR__ . "/../src/routes.php";

$app->run();
