<?php

namespace Deviate\Usergroups\Client;

use Deviate\Shared\Clients\AbstractSearchClient;
use Deviate\Shared\Responses\Clients\ApiPaginatedResponseInterface;
use Deviate\Shared\Search\SearchContainerInterface;

class SearchClient extends AbstractSearchClient implements SearchClientInterface
{
    public function search(SearchContainerInterface $search): ApiPaginatedResponseInterface
    {
        return $this->call('usergroups.search', [
            'parameters' => serialize($search),
        ]);
    }
}
