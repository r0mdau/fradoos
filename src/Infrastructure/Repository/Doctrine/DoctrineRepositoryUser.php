<?php

namespace Fradoos\Infrastructure\Repository\Doctrine;

use Fradoos\Domain\Error\ErrorEntityNotFound;
use Fradoos\Domain\Helper\HelperParameter;
use Fradoos\Domain\Repository\IRepositoryUser;
use Fradoos\Domain\User;

class DoctrineRepositoryUser extends DoctrineRepository implements IRepositoryUser
{
    public function add($user)
    {
        HelperParameter::checkNotEmpty($user, "Impossible to add empty user.");
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user;
    }

    public function delete($id)
    {
        HelperParameter::checkNotEmpty($id, "Impossible to delete user with empty id.");
        $user = $this->get($id);
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    public function get($id)
    {
        HelperParameter::checkNotEmpty($id, "Impossible to get user with empty id.");
        $user = $this->entityManager->find(User::class, $id);
        if (is_null($user)) {
            throw new ErrorEntityNotFound("Impossible to get user with id: $id.");
        }
        return $user;
    }

    public function edit($user)
    {
        HelperParameter::checkNotEmpty($user, "Impossible to edit empty user.");
        $this->entityManager->flush();
        return $user;
    }

    public function getByName($name)
    {
        HelperParameter::checkNotEmpty($name, "Impossible to get user with empty name.");
        return $this->entityManager
            ->getRepository(User::class)
            ->findBy(['name' => $name]);
    }

    public function getAll()
    {
        return $this->entityManager
            ->getRepository(User::class)
            ->findAll();
    }
}
