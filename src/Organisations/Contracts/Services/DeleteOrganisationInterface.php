<?php

namespace Deviate\Organisations\Contracts\Services;

interface DeleteOrganisationInterface
{
    public function deleteByOrganisationId(int $id): void;
}
