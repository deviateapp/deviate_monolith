<?php

namespace Deviate\Organisations\Contracts\Services;

interface UpdateOrganisationInterface
{
    public function updateByOrganisationId(string $id, array $data): ?array;
}
