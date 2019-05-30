<?php

namespace Deviate\Usergroups\Contracts\Repositories;

interface DeleteUsergroupsRepositoryInterface
{
    public function deleteUsergroupById(string $usergroupId): bool;
    public function deleteUsergroupByOrganisationId(string $organisationId): bool;
}
