<?php

namespace Deviate\Organisations;

use Deviate\Organisations\Contracts\Repositories\CreateOrganisationsRepositoryInterface;
use Deviate\Organisations\Contracts\Repositories\DeleteOrganisationsRepositoryInterface;
use Deviate\Organisations\Contracts\Repositories\FetchOrganisationsRepositoryInterface;
use Deviate\Organisations\Contracts\Repositories\UpdateOrganisationsRepositoryInterface;
use Deviate\Organisations\Contracts\Services\CreateOrganisationInterface;
use Deviate\Organisations\Contracts\Services\DeleteOrganisationInterface;
use Deviate\Organisations\Contracts\Services\FetchOrganisationInterface;
use Deviate\Organisations\Contracts\Services\UpdateOrganisationInterface;
use Deviate\Organisations\Events\Subscribers\EventSubscriber;
use Deviate\Organisations\Repositories\CreateOrganisationsRepository;
use Deviate\Organisations\Repositories\DeleteOrganisationsRepository;
use Deviate\Organisations\Repositories\FetchOrganisationsRepository;
use Deviate\Organisations\Repositories\UpdateOrganisationsRepository;
use Deviate\Organisations\Services\CreateOrganisation;
use Deviate\Organisations\Services\DeleteOrganisation;
use Deviate\Organisations\Services\FetchOrganisation;
use Deviate\Organisations\Services\UpdateOrganisation;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;

class OrganisationsServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Services
        $this->app->bind(FetchOrganisationInterface::class, FetchOrganisation::class);
        $this->app->bind(CreateOrganisationInterface::class, CreateOrganisation::class);
        $this->app->bind(UpdateOrganisationInterface::class, UpdateOrganisation::class);
        $this->app->bind(DeleteOrganisationInterface::class, DeleteOrganisation::class);

        // Repositories
        $this->app->bind(CreateOrganisationsRepositoryInterface::class, CreateOrganisationsRepository::class);
        $this->app->bind(FetchOrganisationsRepositoryInterface::class, FetchOrganisationsRepository::class);
        $this->app->bind(UpdateOrganisationsRepositoryInterface::class, UpdateOrganisationsRepository::class);
        $this->app->bind(DeleteOrganisationsRepositoryInterface::class, DeleteOrganisationsRepository::class);
    }

    public function boot()
    {
        /** @var Dispatcher $events */
        $events = app(Dispatcher::class);
        $events->subscribe(EventSubscriber::class);
    }
}
