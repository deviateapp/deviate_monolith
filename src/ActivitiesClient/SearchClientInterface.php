<?php

namespace Deviate\Activities\Client;

use Deviate\Shared\Responses\Clients\ApiPaginatedResponseInterface;
use Deviate\Shared\Search\SearchContainerInterface;

interface SearchClientInterface
{
    public function searchActivities(SearchContainerInterface $search): ApiPaginatedResponseInterface;
    public function searchCollections(SearchContainerInterface $search): ApiPaginatedResponseInterface;
}
