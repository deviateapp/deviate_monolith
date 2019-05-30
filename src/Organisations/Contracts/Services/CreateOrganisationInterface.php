<?php

namespace Deviate\Organisations\Contracts\Services;

interface CreateOrganisationInterface
{
    public function createSingleOrganisation(array $data): array;
}
