<?php

namespace Deviate\Shared\Clients;

use Deviate\Shared\Responses\Clients\ApiPaginatedResponseInterface;
use Deviate\Shared\Search\SearchContainerInterface;

interface SearchClientInterface
{
    public function search(SearchContainerInterface $search): ApiPaginatedResponseInterface;
}
