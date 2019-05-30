<?php

namespace Deviate\Organisations\Repositories;

use Deviate\Organisations\Contracts\Repositories\CreateOrganisationsRepositoryInterface;
use Deviate\Organisations\Models\Eloquent\Organisation;
use Deviate\Organisations\Models\Values\Slug;
use Deviate\Shared\Repositories\AbstractRepository;

class CreateOrganisationsRepository extends AbstractRepository implements CreateOrganisationsRepositoryInterface
{
    /** @var Organisation */
    private $organisation;

    public function __construct(Organisation $organisation)
    {
        $this->organisation = $organisation;
    }

    public function createOrganisation(array $data): int
    {
        $organisation = $this->organisation->newQuery()->create([
            'name' => $data['name'],
            'slug' => Slug::format($data['slug'] ?? $data['name']),
        ]);

        return $organisation->id;
    }
}
