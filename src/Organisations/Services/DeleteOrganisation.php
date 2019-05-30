<?php

namespace Deviate\Organisations\Services;

use Deviate\Organisations\Contracts\Repositories\DeleteOrganisationsRepositoryInterface;
use Deviate\Organisations\Contracts\Services\DeleteOrganisationInterface;

class DeleteOrganisation implements DeleteOrganisationInterface
{
    /** @var DeleteOrganisationsRepositoryInterface */
    private $deletesOrganisations;

    public function __construct(DeleteOrganisationsRepositoryInterface $deletesOrganisations)
    {
        $this->deletesOrganisations = $deletesOrganisations;
    }

    public function deleteByOrganisationId(int $id): void
    {
        $this->deletesOrganisations->deleteOrganisationById($id);
    }
}
