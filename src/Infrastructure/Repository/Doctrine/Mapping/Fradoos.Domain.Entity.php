<?php

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

/** @var TYPE_NAME $metadata */
$builder = new ClassMetadataBuilder($metadata);
$builder->setMappedSuperClass();
$builder->createField('id', 'integer')->makePrimaryKey()->generatedValue()->build();