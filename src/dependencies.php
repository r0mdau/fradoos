<?php

use Fradoos\Application\Presentation\JsonPresentations;
use Fradoos\Domain\Presentation\Presentations;
use Fradoos\Domain\Repository\Repositories;
use Fradoos\Infrastructure\Configuration;
use Fradoos\Infrastructure\Repository\Doctrine\DoctrineRepositories;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

$container = $app->getContainer();

$container["logger"] = function ($c) use ($configuration) {
    $logger = new Logger("webservice");
    $streamHandler = new StreamHandler($configuration["general"]["log.file"], $configuration["general"]["log.level"]);
    $streamHandler->setFormatter(new LineFormatter("[%datetime%] %level_name% %message%\n", 'Y-m-d H:i:s.u'));
    $logger->pushHandler($streamHandler);
    return $logger;
};

Configuration::init($configuration);
Repositories::initialize(new DoctrineRepositories($configuration['database']));
Presentations::initialize(new JsonPresentations());