<?php

namespace Deviate\Users\Contracts\Repositories;

interface DeleteUsersRepositoryInterface
{
    public function deleteUserById(int $id): bool;
    public function deleteUsersByOrganisationId(int $id): bool;
}
