<?php

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

$builder = new ClassMetadataBuilder($metadata);
$builder->setMappedSuperClass();
$builder->createField('id', 'integer')->makePrimaryKey()->generatedValue()->build();