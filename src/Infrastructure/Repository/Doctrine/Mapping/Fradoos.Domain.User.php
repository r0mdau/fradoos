<?php

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

$builder = new ClassMetadataBuilder($metadata);
$builder->setTable('user');
$builder->addField('name', 'string', ['length' => 255, 'nullable' => false]);
