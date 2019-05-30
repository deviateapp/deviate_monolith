<?php

namespace Deviate\Organisations\Contracts\Repositories;

interface CreateOrganisationsRepositoryInterface
{
    public function createOrganisation(array $data): string;
}
