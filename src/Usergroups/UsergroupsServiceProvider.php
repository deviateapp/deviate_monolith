<?php

namespace Deviate\Usergroups;

use Carbon\Laravel\ServiceProvider;
use Deviate\Usergroups\Contracts\Repositories\CreateUsergroupsRepositoryInterface;
use Deviate\Usergroups\Contracts\Repositories\DeleteUsergroupsRepositoryInterface;
use Deviate\Usergroups\Contracts\Repositories\FetchUsergroupsRepositoryInterface;
use Deviate\Usergroups\Contracts\Repositories\MembershipRepositoryInterface;
use Deviate\Usergroups\Contracts\Repositories\PermissionsRepositoryInterface;
use Deviate\Usergroups\Contracts\Repositories\UsergroupPermissionsRepositoryInterface;
use Deviate\Usergroups\Contracts\Repositories\UpdateUsergroupsRepositoryInterface;
use Deviate\Usergroups\Contracts\Services\CreateUsergroupInterface;
use Deviate\Usergroups\Contracts\Services\DeleteUsergroupInterface;
use Deviate\Usergroups\Contracts\Services\FetchUsergroupInterface;
use Deviate\Usergroups\Contracts\Services\MembershipInterface;
use Deviate\Usergroups\Contracts\Services\PermissionsInterface;
use Deviate\Usergroups\Contracts\Services\UpdateUsergroupInterface;
use Deviate\Usergroups\Events\Subscribers\MembershipEventSubscriber;
use Deviate\Usergroups\Events\Subscribers\PermissionsEventSubscriber;
use Deviate\Usergroups\Events\Subscribers\UsergroupsEventSubscriber;
use Deviate\Usergroups\Repositories\CreateUsergroupsRepository;
use Deviate\Usergroups\Repositories\DeleteUsergroupsRepository;
use Deviate\Usergroups\Repositories\FetchUsergroupsRepository;
use Deviate\Usergroups\Repositories\MembershipRepository;
use Deviate\Usergroups\Repositories\PermissionsRepository;
use Deviate\Usergroups\Repositories\UsergroupPermissionsRepository;
use Deviate\Usergroups\Repositories\UpdateUsergroupsRepository;
use Deviate\Usergroups\Services\CreateUsergroup;
use Deviate\Usergroups\Services\DeleteUsergroup;
use Deviate\Usergroups\Services\FetchUsergroup;
use Deviate\Usergroups\Services\Membership;
use Deviate\Usergroups\Services\Permissions;
use Deviate\Usergroups\Services\UpdateUsergroup;
use Illuminate\Contracts\Events\Dispatcher;

class UsergroupsServiceProvider extends ServiceProvider
{
    public function register()
    {
        /** Services */
        $this->app->bind(FetchUsergroupInterface::class, FetchUsergroup::class);
        $this->app->bind(CreateUsergroupInterface::class, CreateUsergroup::class);
        $this->app->bind(UpdateUsergroupInterface::class, UpdateUsergroup::class);
        $this->app->bind(DeleteUsergroupInterface::class, DeleteUsergroup::class);
        $this->app->bind(MembershipInterface::class, Membership::class);
        $this->app->bind(PermissionsInterface::class, Permissions::class);

        /** Repositories */
        $this->app->bind(FetchUsergroupsRepositoryInterface::class, FetchUsergroupsRepository::class);
        $this->app->bind(CreateUsergroupsRepositoryInterface::class, CreateUsergroupsRepository::class);
        $this->app->bind(DeleteUsergroupsRepositoryInterface::class, DeleteUsergroupsRepository::class);
        $this->app->bind(UpdateUsergroupsRepositoryInterface::class, UpdateUsergroupsRepository::class);
        $this->app->bind(MembershipRepositoryInterface::class, MembershipRepository::class);
        $this->app->bind(PermissionsRepositoryInterface::class, PermissionsRepository::class);
        $this->app->bind(UsergroupPermissionsRepositoryInterface::class, UsergroupPermissionsRepository::class);
    }

    public function boot()
    {
        /** @var Dispatcher $events */
        $events = app(Dispatcher::class);
        $events->subscribe(UsergroupsEventSubscriber::class);
        $events->subscribe(MembershipEventSubscriber::class);
        $events->subscribe(PermissionsEventSubscriber::class);
    }
}
