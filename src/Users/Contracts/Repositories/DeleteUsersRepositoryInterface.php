<?php

namespace Deviate\Users\Contracts\Repositories;

interface DeleteUsersRepositoryInterface
{
    public function deleteUserById(string $id): bool;
    public function deleteUsersByOrganisationId(string $id): bool;
}
