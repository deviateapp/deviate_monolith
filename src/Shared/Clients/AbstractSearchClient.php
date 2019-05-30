<?php

namespace Deviate\Shared\Clients;

use Deviate\Shared\Responses\Clients\ApiPaginatedResponse;
use Deviate\Shared\Responses\Clients\ApiResponseInterface;

abstract class AbstractSearchClient extends AbstractClient
{
    protected function toApiResponse(?array $response): ApiResponseInterface
    {
        return new ApiPaginatedResponse($response);
    }
}
