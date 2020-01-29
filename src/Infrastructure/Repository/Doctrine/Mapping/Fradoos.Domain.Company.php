<?php

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

$builder = new ClassMetadataBuilder($metadata);
$builder->setTable("company");
$builder->addField("name", "string", ["length" => 255, "nullable" => false]);
