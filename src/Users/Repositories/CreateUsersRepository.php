<?php

namespace Deviate\Users\Repositories;

use Deviate\Shared\Repositories\AbstractRepository;
use Deviate\Users\Models\Eloquent\User;
use Deviate\Users\Contracts\Repositories\CreateUsersRepositoryInterface;

class CreateUsersRepository extends AbstractRepository implements CreateUsersRepositoryInterface
{
    /** @var User */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function createUser(array $data): string
    {
        $user = $this->user->newQuery()->create([
            'organisation_id' => $this->decode($data['organisation_id']),
            'forename'        => $data['forename'],
            'surname'         => $data['surname'],
            'email'           => $data['email'],
            'password'        => $data['password'],
        ]);

        return $this->encode($user->id);
    }
}
