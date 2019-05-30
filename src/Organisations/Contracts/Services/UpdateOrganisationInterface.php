<?php

namespace Deviate\Organisations\Contracts\Services;

interface UpdateOrganisationInterface
{
    public function updateByOrganisationId(int $id, array $data): ?array;
}
