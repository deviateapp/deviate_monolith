<?php

namespace Deviate\Organisations\Contracts\Events;

use Deviate\Shared\Events\EventSubscriberInterface as BaseEventSubscriberInterface;

interface EventSubscriberInterface extends BaseEventSubscriberInterface
{
    public function handleSearchOrganisations(array $payload): array;
    public function handleFetchOrganisationById(array $payload): array;
    public function handleCreateOrganisation(array $payload): array;
    public function handleUpdateOrganisation(array $data): array;
    public function handleDeleteOrganisation(array $payload): void;
}
