<?php

namespace Deviate\Organisations\Contracts\Services;

interface DeleteOrganisationInterface
{
    public function deleteByOrganisationId(string $id): void;
}
