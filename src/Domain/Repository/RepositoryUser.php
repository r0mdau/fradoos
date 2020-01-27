<?php

namespace Fradoos\Domain\Repository;

interface RepositoryUser
{
    public function add($user);

    public function delete($id);

    public function edit($user);

    public function get($id);

    public function getAll();

    public function getByName($name);
}