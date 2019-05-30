<?php

namespace Deviate\Usergroups\Contracts\Repositories;

interface DeleteUsergroupsRepositoryInterface
{
    public function deleteUsergroupById(int $usergroupId): bool;
    public function deleteUsergroupByOrganisationId(int $organisationId): bool;
}
