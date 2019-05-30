<?php

namespace Deviate\Organisations\Events\Subscribers;

use Deviate\Organisations\Contracts\Events\EventSubscriberInterface;
use Deviate\Organisations\Contracts\Services\CreateOrganisationInterface;
use Deviate\Organisations\Contracts\Services\FetchOrganisationInterface;
use Deviate\Organisations\Contracts\Services\DeleteOrganisationInterface;
use Deviate\Organisations\Contracts\Services\UpdateOrganisationInterface;
use Deviate\Shared\Events\AbstractEventSubscriber;

class EventSubscriber extends AbstractEventSubscriber implements EventSubscriberInterface
{
    /** @var array */
    protected $events = [
        'organisations.search'      => 'handleSearchOrganisations',
        'organisations.fetch.by_id' => 'handleFetchOrganisationById',
        'organisations.create'      => 'handleCreateOrganisation',
        'organisations.update'      => 'handleUpdateOrganisation',
        'organisations.delete'      => 'handleDeleteOrganisation',
    ];

    /** @var FetchOrganisationInterface */
    private $fetchOrganisation;

    /** @var CreateOrganisationInterface */
    private $createOrganisation;

    /** @var UpdateOrganisationInterface */
    private $updateOrganisation;

    /** @var DeleteOrganisationInterface */
    private $deleteOrganisation;

    public function __construct(
        FetchOrganisationInterface $fetchOrganisation,
        CreateOrganisationInterface $createOrganisation,
        UpdateOrganisationInterface $updateOrganisation,
        DeleteOrganisationInterface $deleteOrganisation
    ) {
        $this->fetchOrganisation  = $fetchOrganisation;
        $this->createOrganisation = $createOrganisation;
        $this->updateOrganisation = $updateOrganisation;
        $this->deleteOrganisation = $deleteOrganisation;
    }

    public function handleSearchOrganisations(array $payload): array
    {
        return $this->fetchOrganisation->search(unserialize($payload['parameters']));
    }

    public function handleFetchOrganisationById(array $payload): array
    {
        return $this->fetchOrganisation->fetchById($payload['id']);
    }

    public function handleCreateOrganisation(array $payload): array
    {
        return $this->createOrganisation->createSingleOrganisation($payload);
    }

    public function handleUpdateOrganisation(array $data): array
    {
        return $this->updateOrganisation->updateByOrganisationId($data['id'], $data);
    }

    public function handleDeleteOrganisation(array $payload): void
    {
        $this->deleteOrganisation->deleteByOrganisationId($payload['id']);
    }
}
