<?php

namespace Deviate\Activities\Tests\Services;

use Deviate\Activities\Client\ActivitiesClientInterface;
use Deviate\Activities\Client\BookingsClientInterface;
use Deviate\Activities\Client\InvitationsClientInterface;
use Deviate\Activities\Client\CollectionsClientInterface;
use Deviate\Activities\Client\SearchBookingsClientInterface;
use Deviate\Activities\Client\SearchClientInterface;
use Tests\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /** @var CollectionsClientInterface */
    protected $collectionsClient;

    /** @var SearchClientInterface */
    protected $searchClient;

    /** @var ActivitiesClientInterface */
    protected $activitiesClient;

    /** @var BookingsClientInterface */
    protected $bookingsClient;

    /** @var SearchBookingsClientInterface */
    protected $searchBookingsClient;

    /** @var InvitationsClientInterface */
    protected $invitationsClient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->collectionsClient    = app(CollectionsClientInterface::class);
        $this->searchClient         = app(SearchClientInterface::class);
        $this->activitiesClient     = app(ActivitiesClientInterface::class);
        $this->bookingsClient       = app(BookingsClientInterface::class);
        $this->searchBookingsClient = app(SearchBookingsClientInterface::class);
        $this->invitationsClient    = app(InvitationsClientInterface::class);
    }
}
