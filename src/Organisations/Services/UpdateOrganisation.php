<?php

namespace Deviate\Organisations\Services;

use Deviate\Organisations\Contracts\Repositories\FetchOrganisationsRepositoryInterface;
use Deviate\Organisations\Contracts\Repositories\UpdateOrganisationsRepositoryInterface;
use Deviate\Organisations\Contracts\Services\UpdateOrganisationInterface;
use Deviate\Organisations\Validators\UpdateOrganisationValidator;

class UpdateOrganisation implements UpdateOrganisationInterface
{
    /** @var UpdateOrganisationsRepositoryInterface */
    private $updatesOrganisations;

    /** @var FetchOrganisationsRepositoryInterface */
    private $fetchesOrganisations;

    /** @var UpdateOrganisationValidator */
    private $validator;

    public function __construct(
        UpdateOrganisationsRepositoryInterface $updatesOrganisations,
        FetchOrganisationsRepositoryInterface $fetchesOrganisations,
        UpdateOrganisationValidator $validator
    ) {
        $this->updatesOrganisations = $updatesOrganisations;
        $this->fetchesOrganisations = $fetchesOrganisations;
        $this->validator            = $validator;
    }

    public function updateByOrganisationId(string $id, array $data): ?array
    {
        $this->validator->validate($data, [
            'id' => $id,
        ]);

        $this->updatesOrganisations->updateOrganisationById($id, $data);

        return $this->fetchesOrganisations->fetchOrganisationById($id);
    }
}
