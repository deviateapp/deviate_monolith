<?php

namespace Deviate\Organisations\Repositories;

use Deviate\Organisations\Contracts\Repositories\UpdateOrganisationsRepositoryInterface;
use Deviate\Organisations\Models\Eloquent\Organisation;
use Deviate\Organisations\Models\Values\Slug;
use Deviate\Shared\Repositories\AbstractRepository;

class UpdateOrganisationsRepository extends AbstractRepository implements UpdateOrganisationsRepositoryInterface
{
    /** @var Organisation */
    private $organisation;

    public function __construct(Organisation $organisation)
    {
        $this->organisation = $organisation;
    }

    public function updateOrganisationById(string $id, array $data): bool
    {
        $organisation = $this->organisation->newQuery()->findOrFail($id)->toArray();
        $data         = array_merge($organisation, $data);

        return (bool) $this->organisation->newQuery()
            ->findOrFail($id)
            ->update([
                'name' => $data['name'],
                'slug' => Slug::format($data['slug']),
            ]);
    }
}
