<?php

namespace Deviate\Activities\Services\Bookings;

use Deviate\Activities\Client\ActivitiesClientInterface;
use Deviate\Activities\Contracts\Repositories\BookingsRepositoryInterface;
use Deviate\Activities\Contracts\Services\Bookings\SearchesBookingsInterface;
use Deviate\Shared\Search\Filters\MustBeIn;
use Deviate\Shared\Search\SearchContainerInterface;
use Deviate\Users\Client\FetchesUsersClientInterface;
use Deviate\Users\Client\SearchClientInterface as SearchUsersClientInterface;
use Deviate\Activities\Client\SearchClientInterface as SearchActivitiesClientInterface;

class SearchesBookings implements SearchesBookingsInterface
{
    private $repository;
    private $searchesUsers;
    private $fetchesUsers;
    private $fetchesActivities;
    private $searchesActivities;

    public function __construct(
        BookingsRepositoryInterface $repository,
        SearchUsersClientInterface $searchesUsers,
        FetchesUsersClientInterface $fetchesUsers,
        ActivitiesClientInterface $fetchesActivities,
        SearchActivitiesClientInterface $searchesActivities
    ) {
        $this->repository         = $repository;
        $this->searchesUsers      = $searchesUsers;
        $this->fetchesUsers       = $fetchesUsers;
        $this->fetchesActivities  = $fetchesActivities;
        $this->searchesActivities = $searchesActivities;
    }

    public function listBookedUsers(string $activityId, SearchContainerInterface $search): array
    {
        $this->fetchesActivities->fetchById($activityId)->rethrow();

        $bookings = $this->repository->listBookedUsers($activityId);

        $search->addFilter(new MustBeIn('id', $bookings));

        return $this->searchesUsers->search($search)->toArray();
    }

    public function listActivitiesBooked(string $userId, SearchContainerInterface $search): array
    {
        $this->fetchesUsers->fetchUserById($userId)->rethrow();

        $bookings = $this->repository->listBookedActivities($userId);

        $search->addFilter(new MustBeIn('id', $bookings));

        return $this->searchesActivities->searchActivities($search)->toArray();
    }
}
