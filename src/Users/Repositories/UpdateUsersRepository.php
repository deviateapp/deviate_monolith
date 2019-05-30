<?php

namespace Deviate\Users\Repositories;

use Carbon\Carbon;
use Deviate\Shared\Repositories\AbstractRepository;
use Deviate\Users\Models\Eloquent\User;
use Deviate\Users\Contracts\Repositories\UpdateUsersRepositoryInterface;

class UpdateUsersRepository extends AbstractRepository implements UpdateUsersRepositoryInterface
{
    /** @var User */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function updateUserById(int $id, array $details): bool
    {
        $user = $this->user->newQuery()->withTrashed()->findOrFail($id)->toArray();

        $data = array_merge($user, $details);

        return (bool) $this->user->newQuery()->withTrashed()->findOrFail($id)->update([
            'forename'       => $data['forename'],
            'surname'        => $data['surname'],
            'email'          => $data['email'],
            'password'       => $data['password'],
            'remember_token' => $data['remember_token'],
            'deleted_at'     => $data['deleted_at'],
        ]);
    }

    public function updateActivationById(int $id, bool $isActive): bool
    {
        return $this->updateUserById($id, [
            'deleted_at' => $isActive ? null : Carbon::now(),
        ]);
    }
}
