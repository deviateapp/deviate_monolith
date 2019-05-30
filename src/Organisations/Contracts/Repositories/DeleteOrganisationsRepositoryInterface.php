<?php

namespace Deviate\Organisations\Contracts\Repositories;

interface DeleteOrganisationsRepositoryInterface
{
    public function deleteOrganisationById(int $id): void;
}
