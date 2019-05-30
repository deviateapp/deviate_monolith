<?php

namespace Deviate\Organisations\Repositories;

use Deviate\Organisations\Contracts\Repositories\DeleteOrganisationsRepositoryInterface;
use Deviate\Organisations\Models\Eloquent\Organisation;
use Deviate\Shared\Repositories\AbstractRepository;

class DeleteOrganisationsRepository extends AbstractRepository implements DeleteOrganisationsRepositoryInterface
{
    /** @var Organisation */
    private $organisation;

    public function __construct(Organisation $organisation)
    {
        $this->organisation = $organisation;
    }

    public function deleteOrganisationById(string $id): void
    {
        $this->organisation->newQuery()->findOrFail($id)->delete();
    }
}
