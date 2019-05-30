<?php

namespace App\Providers;

use Deviate\Organisations\Client as Organisations;
use Deviate\Users\Client as Users;
use Deviate\Usergroups\Client as Usergroups;
use Deviate\Activities\Client as Activities;
use Hashids\Hashids;
use Hashids\HashidsInterface;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Packages
        $this->app->bind(HashidsInterface::class, function (Container $app) {
            return new Hashids($app['config']['app']['key'], 6);
        });

        $this->registerUserClients();
        $this->registerOrganisationClients();
        $this->registerUsergroupClients();
        $this->registerActivityClients();
    }

    private function registerUserClients()
    {
        $this->app->bind(Users\AuthenticatesUsersClientInterface::class, Users\AuthenticatesUsersClient::class);
        $this->app->bind(Users\CreatesUsersClientInterface::class, Users\CreatesUsersClient::class);
        $this->app->bind(Users\DeletesUsersClientInterface::class, Users\DeletesUsersClient::class);
        $this->app->bind(Users\FetchesUsersClientInterface::class, Users\FetchesUsersClient::class);
        $this->app->bind(Users\UpdatesUsersClientInterface::class, Users\UpdatesUsersClient::class);

        $this->app->bind(Users\SearchClientInterface::class, Users\SearchClient::class);
        $this->app->bind(Users\AvatarsClientInterface::class, Users\AvatarsClient::class);
    }

    private function registerOrganisationClients()
    {
        $this->app->bind(Organisations\ClientInterface::class, Organisations\Client::class);
        $this->app->bind(Organisations\SearchClientInterface::class, Organisations\SearchClient::class);
    }

    private function registerUsergroupClients()
    {
        $this->app->bind(Usergroups\UsergroupsClientInterface::class, Usergroups\UsergroupsClient::class);
        $this->app->bind(Usergroups\MembershipClientInterface::class, Usergroups\MembershipClient::class);
        $this->app->bind(Usergroups\SearchClientInterface::class, Usergroups\SearchClient::class);
        $this->app->bind(Usergroups\PermissionsClientInterface::class, Usergroups\PermissionsClient::class);
    }

    private function registerActivityClients()
    {
        $this->app->bind(Activities\CollectionsClientInterface::class, Activities\CollectionsClient::class);
        $this->app->bind(Activities\SearchClientInterface::class, Activities\SearchClient::class);
        $this->app->bind(Activities\ActivitiesClientInterface::class, Activities\ActivitiesClient::class);
        $this->app->bind(Activities\BookingsClientInterface::class, Activities\BookingsClient::class);
        $this->app->bind(Activities\SearchBookingsClientInterface::class, Activities\SearchBookingsClient::class);
        $this->app->bind(Activities\InvitationsClientInterface::class, Activities\InvitationsClient::class);
    }
}
