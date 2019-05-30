<?php

namespace Deviate\Organisations\Client;

use Deviate\Shared\Responses\Clients\ApiResponseInterface;

interface ClientInterface
{
    public function fetchOrganisationById(string $id): ApiResponseInterface;
    public function createOrganisation(array $data): ApiResponseInterface;
    public function updateOrganisation(string $id, array $data): ApiResponseInterface;
    public function deleteOrganisation(string $id): ApiResponseInterface;
}
