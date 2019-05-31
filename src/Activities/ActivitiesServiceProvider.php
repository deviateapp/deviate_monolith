<?php

namespace Deviate\Activities;

use Deviate\Activities\Contracts\Repositories\ActivitiesRepositoryInterface;
use Deviate\Activities\Contracts\Repositories\ActivityCollectionsRepositoryInterface;
use Deviate\Activities\Contracts\Repositories\BookingsRepositoryInterface;
use Deviate\Activities\Contracts\Repositories\InvitationsRepositoryInterface;
use Deviate\Activities\Contracts\Services\Activities\CreateActivityInterface;
use Deviate\Activities\Contracts\Services\Activities\DeleteActivityInterface;
use Deviate\Activities\Contracts\Services\Activities\FetchActivityInterface;
use Deviate\Activities\Contracts\Services\Activities\UpdateActivityInterface;
use Deviate\Activities\Contracts\Services\ActivityCollections\CreateActivityCollectionInterface;
use Deviate\Activities\Contracts\Services\ActivityCollections\DeleteActivityCollectionInterface;
use Deviate\Activities\Contracts\Services\ActivityCollections\FetchActivityCollectionInterface;
use Deviate\Activities\Contracts\Services\ActivityCollections\UpdateActivityCollectionInterface;
use Deviate\Activities\Contracts\Services\Bookings\BookActivityInterface;
use Deviate\Activities\Contracts\Services\Bookings\SearchesBookingsInterface;
use Deviate\Activities\Contracts\Services\Bookings\UnbookActivityInterface;
use Deviate\Activities\Contracts\Services\Invitations\InviteUserInterface;
use Deviate\Activities\Contracts\Services\Invitations\SearchInvitationsInterface;
use Deviate\Activities\Contracts\Services\Invitations\UninviteUserInterface;
use Deviate\Activities\Events\ActivitiesEventSubscriber;
use Deviate\Activities\Events\BookingsEventSubscriber;
use Deviate\Activities\Events\CollectionsEventSubscriber;
use Deviate\Activities\Events\InvitationsEventSubscriber;
use Deviate\Activities\Repositories\ActivitiesRepository;
use Deviate\Activities\Repositories\ActivityCollectionsRepository;
use Deviate\Activities\Repositories\BookingsRepository;
use Deviate\Activities\Repositories\InvitationsRepository;
use Deviate\Activities\Services\Activities\CreateActivity;
use Deviate\Activities\Services\Activities\DeleteActivity;
use Deviate\Activities\Services\Activities\FetchActivity;
use Deviate\Activities\Services\Activities\UpdateActivity;
use Deviate\Activities\Services\ActivityCollections\CreateActivityCollection;
use Deviate\Activities\Services\ActivityCollections\DeleteActivityCollection;
use Deviate\Activities\Services\ActivityCollections\FetchActivityCollection;
use Deviate\Activities\Services\ActivityCollections\UpdateActivityCollection;
use Deviate\Activities\Services\Bookings\BookActivity;
use Deviate\Activities\Services\Bookings\SearchesBookings;
use Deviate\Activities\Services\Bookings\UnbookActivity;
use Deviate\Activities\Services\Invitations\InviteUser;
use Deviate\Activities\Services\Invitations\SearchInvitations;
use Deviate\Activities\Services\Invitations\UninviteUser;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;

class ActivitiesServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Services
        $this->app->bind(FetchActivityCollectionInterface::class, FetchActivityCollection::class);
        $this->app->bind(CreateActivityCollectionInterface::class, CreateActivityCollection::class);
        $this->app->bind(DeleteActivityCollectionInterface::class, DeleteActivityCollection::class);
        $this->app->bind(UpdateActivityCollectionInterface::class, UpdateActivityCollection::class);
        $this->app->bind(FetchActivityInterface::class, FetchActivity::class);
        $this->app->bind(CreateActivityInterface::class, CreateActivity::class);
        $this->app->bind(UpdateActivityInterface::class, UpdateActivity::class);
        $this->app->bind(DeleteActivityInterface::class, DeleteActivity::class);
        $this->app->bind(BookActivityInterface::class, BookActivity::class);
        $this->app->bind(UnbookActivityInterface::class, UnbookActivity::class);
        $this->app->bind(SearchesBookingsInterface::class, SearchesBookings::class);
        $this->app->bind(InviteUserInterface::class, InviteUser::class);
        $this->app->bind(UninviteUserInterface::class, UninviteUser::class);
        $this->app->bind(SearchInvitationsInterface::class, SearchInvitations::class);

        // Repositories
        $this->app->bind(ActivityCollectionsRepositoryInterface::class, ActivityCollectionsRepository::class);
        $this->app->bind(ActivitiesRepositoryInterface::class, ActivitiesRepository::class);
        $this->app->bind(BookingsRepositoryInterface::class, BookingsRepository::class);
        $this->app->bind(InvitationsRepositoryInterface::class, InvitationsRepository::class);
    }

    public function boot()
    {
        /** @var Dispatcher $events */
        $events = app(Dispatcher::class);
        $events->subscribe(CollectionsEventSubscriber::class);
        $events->subscribe(ActivitiesEventSubscriber::class);
        $events->subscribe(BookingsEventSubscriber::class);
        $events->subscribe(InvitationsEventSubscriber::class);
    }
}
