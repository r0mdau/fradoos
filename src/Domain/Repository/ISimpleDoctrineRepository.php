<?php

namespace Fradoos\Domain\Repository;

interface ISimpleDoctrineRepository
{
    public function add($user);

    public function delete($id);

    public function edit($user);

    public function get($id);

    public function getAll();
}