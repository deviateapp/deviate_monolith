<?php

namespace Deviate\Users;

use Deviate\Users\Contracts\Factories\Avatars\GeneratorAdapterInterface;
use Deviate\Users\Contracts\Repositories\CreateAvatarsRepositoryInterface;
use Deviate\Users\Contracts\Repositories\CreateUsersRepositoryInterface;
use Deviate\Users\Contracts\Repositories\DeleteAvatarsRepositoryInterface;
use Deviate\Users\Contracts\Repositories\DeleteUsersRepositoryInterface;
use Deviate\Users\Contracts\Repositories\FetchAvatarsRepositoryInterface;
use Deviate\Users\Contracts\Repositories\FetchUsersRepositoryInterface;
use Deviate\Users\Contracts\Services\Avatars\CreateAvatarInterface;
use Deviate\Users\Contracts\Services\Users\CreateUserInterface;
use Deviate\Users\Contracts\Repositories\UpdateUsersRepositoryInterface;
use Deviate\Users\Contracts\Services\Avatars\DeleteAvatarInterface;
use Deviate\Users\Contracts\Services\Avatars\FetchAvatarInterface;
use Deviate\Users\Contracts\Services\Users\DeleteUserInterface;
use Deviate\Users\Contracts\Services\Users\FetchUserInterface;
use Deviate\Users\Contracts\Services\Avatars\UpdateAvatarInterface;
use Deviate\Users\Contracts\Services\Users\UpdateUserInterface;
use Deviate\Users\Contracts\Services\Users\UserValidationInterface;
use Deviate\Users\Events\Subscribers\AvatarsEventSubscriber;
use Deviate\Users\Events\Subscribers\SearchEventSubscriber;
use Deviate\Users\Events\Subscribers\UsersEventSubscriber;
use Deviate\Users\Factories\Avatars\GravatarAdapter;
use Deviate\Users\Repositories\CreateAvatarsRepository;
use Deviate\Users\Repositories\CreateUsersRepository;
use Deviate\Users\Repositories\DeleteAvatarsRepository;
use Deviate\Users\Repositories\DeleteUsersRepository;
use Deviate\Users\Repositories\FetchAvatarsRepository;
use Deviate\Users\Repositories\FetchUsersRepository;
use Deviate\Users\Services\Avatars\CreateAvatar;
use Deviate\Users\Services\Users\CreateUser;
use Deviate\Users\Repositories\UpdateUsersRepository;
use Deviate\Users\Services\Avatars\DeleteAvatar;
use Deviate\Users\Services\Avatars\FetchAvatar;
use Deviate\Users\Services\Users\DeleteUser;
use Deviate\Users\Services\Users\FetchUser;
use Deviate\Users\Services\Avatars\UpdateAvatar;
use Deviate\Users\Services\Users\UpdateUser;
use Deviate\Users\Services\Users\UserValidation;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;

class UsersServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerServices();
        $this->registerRepositories();
        $this->registerFactories();
    }

    private function registerServices()
    {
        $this->app->bind(CreateUserInterface::class, CreateUser::class);
        $this->app->bind(FetchUserInterface::class, FetchUser::class);
        $this->app->bind(UpdateUserInterface::class, UpdateUser::class);
        $this->app->bind(UserValidationInterface::class, UserValidation::class);
        $this->app->bind(UpdateAvatarInterface::class, UpdateAvatar::class);
        $this->app->bind(CreateAvatarInterface::class, CreateAvatar::class);
        $this->app->bind(FetchAvatarInterface::class, FetchAvatar::class);
        $this->app->bind(DeleteAvatarInterface::class, DeleteAvatar::class);
        $this->app->bind(DeleteUserInterface::class, DeleteUser::class);
    }

    private function registerRepositories()
    {
        $this->app->bind(FetchAvatarsRepositoryInterface::class, FetchAvatarsRepository::class);
        $this->app->bind(CreateAvatarsRepositoryInterface::class, CreateAvatarsRepository::class);
        $this->app->bind(DeleteAvatarsRepositoryInterface::class, DeleteAvatarsRepository::class);
        $this->app->bind(CreateUsersRepositoryInterface::class, CreateUsersRepository::class);
        $this->app->bind(UpdateUsersRepositoryInterface::class, UpdateUsersRepository::class);
        $this->app->bind(FetchUsersRepositoryInterface::class, FetchUsersRepository::class);
        $this->app->bind(DeleteUsersRepositoryInterface::class, DeleteUsersRepository::class);
    }

    private function registerFactories()
    {
        $this->app->bind(GeneratorAdapterInterface::class, GravatarAdapter::class);
    }

    public function boot()
    {
        /** @var Dispatcher $events */
        $events = app(Dispatcher::class);
        $events->subscribe(UsersEventSubscriber::class);
        $events->subscribe(AvatarsEventSubscriber::class);
        $events->subscribe(SearchEventSubscriber::class);
    }
}
