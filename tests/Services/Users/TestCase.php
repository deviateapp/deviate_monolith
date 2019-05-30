<?php

namespace Deviate\Users\Tests\Services;

use Deviate\Users\Client\AuthenticatesUsersClientInterface;
use Deviate\Users\Client\AvatarsClientInterface;
use Deviate\Users\Client\CreatesUsersClientInterface;
use Deviate\Users\Client\DeletesUsersClientInterface;
use Deviate\Users\Client\FetchesUsersClientInterface;
use Deviate\Users\Client\SearchClientInterface;
use Deviate\Users\Client\UpdatesUsersClientInterface;
use Tests\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /** @var AuthenticatesUsersClientInterface */
    protected $authenticatesUsersClient;

    /** @var CreatesUsersClientInterface */
    protected $createsUsersClient;

    /** @var DeletesUsersClientInterface */
    protected $deletesUsersClient;

    /** @var FetchesUsersClientInterface */
    protected $fetchesUsersClient;

    /** @var UpdatesUsersClientInterface */
    protected $updatesUsersClient;

    /** @var AvatarsClientInterface */
    protected $avatarsClient;

    /** @var SearchClientInterface */
    protected $searchClient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authenticatesUsersClient = app(AuthenticatesUsersClientInterface::class);
        $this->createsUsersClient       = app(CreatesUsersClientInterface::class);
        $this->deletesUsersClient       = app(DeletesUsersClientInterface::class);
        $this->fetchesUsersClient       = app(FetchesUsersClientInterface::class);
        $this->updatesUsersClient       = app(UpdatesUsersClientInterface::class);
        $this->avatarsClient            = app(AvatarsClientInterface::class);
        $this->searchClient             = app(SearchClientInterface::class);
    }
}
