<?php

namespace Deviate\Organisations\Tests\Services;

use Deviate\Organisations\Client\ClientInterface;
use Deviate\Organisations\Client\SearchClientInterface;
use Tests\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /** @var ClientInterface */
    protected $client;

    /** @var SearchClientInterface */
    protected $searchClient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = app(ClientInterface::class);
        $this->searchClient = app(SearchClientInterface::class);
    }
}
