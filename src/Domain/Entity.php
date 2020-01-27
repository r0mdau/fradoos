<?php

namespace Fradoos\Domain;

abstract class Entity
{
    /**
     * @var $id integer
     */
    protected $id;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->id;
    }
}