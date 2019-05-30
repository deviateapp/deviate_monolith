<?php

namespace Deviate\Organisations\Contracts\Repositories;

interface UpdateOrganisationsRepositoryInterface
{
    public function updateOrganisationById(string $id, array $data): bool;
}
