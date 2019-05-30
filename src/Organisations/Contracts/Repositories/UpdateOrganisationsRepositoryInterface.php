<?php

namespace Deviate\Organisations\Contracts\Repositories;

interface UpdateOrganisationsRepositoryInterface
{
    public function updateOrganisationById(int $id, array $data): bool;
}
