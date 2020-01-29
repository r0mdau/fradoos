<?php

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Fradoos\Infrastructure\Repository\Doctrine\DoctrineRepositories;

require_once __DIR__ . '/vendor/autoload.php';

$_SERVER["APP_ENV"] = $_SERVER["APP_ENV"] ?? "development";
$database = parse_ini_file(__DIR__ . '/config/application.' . $_SERVER["APP_ENV"] . '.ini', true)['database'];

$em = DoctrineRepositories::createEntityManager(
    $database,
    new ArrayCache(),
    false
);

$helpers = new Symfony\Component\Console\Helper\HelperSet(array(
    'db' => new ConnectionHelper($em->getConnection()),
    'em' => new EntityManagerHelper($em)
));