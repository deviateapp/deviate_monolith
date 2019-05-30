<?php

declare(strict_types=1);

namespace Deviate\Organisations\Client;

use Deviate\Shared\Clients\AbstractClient;
use Deviate\Shared\Responses\Clients\ApiResponseInterface;

class Client extends AbstractClient implements ClientInterface
{
    public function fetchOrganisationById(string $id): ApiResponseInterface
    {
        return $this->call('organisations.fetch.by_id', [
            'id' => $id,
        ]);
    }

    public function createOrganisation(array $data): ApiResponseInterface
    {
        return $this->call('organisations.create', $data);
    }

    public function updateOrganisation(string $id, array $data): ApiResponseInterface
    {
        return $this->call('organisations.update', array_merge([
            'id' => $id,
        ], $data));
    }

    public function deleteOrganisation(string $id): ApiResponseInterface
    {
        return $this->call('organisations.delete', [
            'id' => $id,
        ]);
    }
}
