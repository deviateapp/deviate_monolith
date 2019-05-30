<?php

namespace Deviate\Organisations\Services;

use Deviate\Organisations\Contracts\Repositories\FetchOrganisationsRepositoryInterface;
use Deviate\Organisations\Contracts\Services\FetchOrganisationInterface;
use Deviate\Organisations\Normalizers\OrganisationSearchNormalizer;
use Deviate\Shared\Search\SearchContainerInterface;

class FetchOrganisation implements FetchOrganisationInterface
{
    /** @var FetchOrganisationsRepositoryInterface */
    private $fetchesOrganisations;

    /** @var OrganisationSearchNormalizer */
    private $normalizer;

    public function __construct(
        FetchOrganisationsRepositoryInterface $fetchesOrganisations,
        OrganisationSearchNormalizer $normalizer
    ) {
        $this->fetchesOrganisations = $fetchesOrganisations;
        $this->normalizer           = $normalizer;
    }

    public function search(SearchContainerInterface $search): array
    {
        return $this->fetchesOrganisations->search($this->normalizer->normalize($search));
    }

    public function fetchById(int $id): array
    {
        return $this->fetchesOrganisations->fetchOrganisationById($id);
    }
}
