<?php

namespace Deviate\Organisations\Repositories;

use Deviate\Organisations\Contracts\Repositories\FetchOrganisationsRepositoryInterface;
use Deviate\Organisations\Models\Eloquent\Organisation;
use Deviate\Organisations\Models\Values\Slug;
use Deviate\Organisations\Transformers\OrganisationTransformer;
use Deviate\Shared\Repositories\AbstractRepository;
use Deviate\Shared\Search\SearchContainerInterface;

class FetchOrganisationsRepository extends AbstractRepository implements FetchOrganisationsRepositoryInterface
{
    /** @var Organisation */
    private $organisation;

    /** @var OrganisationTransformer */
    private $transformer;

    public function __construct(Organisation $organisation, OrganisationTransformer $transformer)
    {
        $this->organisation = $organisation;
        $this->transformer  = $transformer;
    }

    public function search(SearchContainerInterface $search): array
    {
        $paginator = $this->organisation->newQuery()->search($search);

        return $this->transformer->transformSearch($paginator);
    }

    public function fetchByDetails(array $details): array
    {
        /** @var Organisation $organisation */
        $organisation = $this->organisation->newQuery()->where($details)->firstOrFail();

        return $this->transformer->transform($organisation);
    }

    public function fetchOrganisationById(int $id): array
    {
        /** @var Organisation $organisation */
        $organisation = $this->organisation->newQuery()->findOrFail($id);

        return $this->transformer->transform($organisation);
    }

    public function isSlugRegistered(string $slug, ?int $ignoreId = null): bool
    {
        return $this->organisation->newQuery()
            ->whereSlug(Slug::format($slug))
            ->where('id', '!=', $ignoreId)
            ->exists();
    }
}
