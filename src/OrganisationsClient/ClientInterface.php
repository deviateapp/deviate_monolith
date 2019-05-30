<?php

namespace Deviate\Organisations\Client;

use Deviate\Shared\Responses\Clients\ApiResponseInterface;

interface ClientInterface
{
    public function fetchOrganisationById(int $id): ApiResponseInterface;
    public function createOrganisation(array $data): ApiResponseInterface;
    public function updateOrganisation(int $id, array $data): ApiResponseInterface;
    public function deleteOrganisation(int $id): ApiResponseInterface;
}
