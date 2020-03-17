<?php

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

$builder = new ClassMetadataBuilder($metadata);
$builder->setTable("user");
$builder->addField("name", "string", ["length" => 255, "nullable" => false]);
$builder->addField("email", "string", ["length" => 255, "nullable" => false]);

$builder->createManyToOne('company', 'Company')->addJoinColumn('company_id', 'id', true, false, 'no action')->cascadePersist()->build();
$builder->createManyToMany('workingGroups', 'WorkingGroup')->setJoinTable('user_working_group')->addJoinColumn('user_id', 'id')->addInverseJoinColumn('working_group_id', 'id')->cascadePersist()->build();