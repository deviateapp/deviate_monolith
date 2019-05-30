<?php

namespace Deviate\Activities\Client;

use Deviate\Shared\Clients\AbstractSearchClient;
use Deviate\Shared\Responses\Clients\ApiPaginatedResponseInterface;
use Deviate\Shared\Search\SearchContainerInterface;

class SearchClient extends AbstractSearchClient implements SearchClientInterface
{
    public function searchActivities(SearchContainerInterface $search): ApiPaginatedResponseInterface
    {
        return $this->call('activities.search', [
            'parameters' => serialize($search),
        ]);
    }

    public function searchCollections(SearchContainerInterface $search): ApiPaginatedResponseInterface
    {
        return $this->call('activities.collections.search', [
            'parameters' => serialize($search),
        ]);
    }
}
