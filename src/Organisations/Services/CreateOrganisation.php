<?php

namespace Deviate\Organisations\Services;

use Deviate\Organisations\Contracts\Repositories\CreateOrganisationsRepositoryInterface;
use Deviate\Organisations\Contracts\Repositories\FetchOrganisationsRepositoryInterface;
use Deviate\Organisations\Contracts\Services\CreateOrganisationInterface;
use Deviate\Organisations\Validators\NewOrganisationValidator;

class CreateOrganisation implements CreateOrganisationInterface
{
    /** @var CreateOrganisationsRepositoryInterface */
    private $createsOrganisations;

    /** @var FetchOrganisationsRepositoryInterface */
    private $fetchesOrganisations;

    /** @var NewOrganisationValidator */
    private $validator;

    public function __construct(
        CreateOrganisationsRepositoryInterface $createsOrganisations,
        FetchOrganisationsRepositoryInterface $fetchesOrganisations,
        NewOrganisationValidator $validator
    ) {
        $this->createsOrganisations = $createsOrganisations;
        $this->fetchesOrganisations = $fetchesOrganisations;
        $this->validator            = $validator;
    }

    public function createSingleOrganisation(array $data): array
    {
        $this->validator->validate([
            'name' => $data['name'] ?? null,
            'slug' => $data['slug'] ?? $data['name'],
        ]);

        $id = $this->createsOrganisations->createOrganisation($data);

        return $this->fetchesOrganisations->fetchOrganisationById($id);
    }
}
