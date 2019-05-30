<?php

namespace Deviate\Users\Services\Users;

use Deviate\Users\Contracts\Repositories\DeleteUsersRepositoryInterface;
use Deviate\Users\Contracts\Repositories\FetchUsersRepositoryInterface;
use Deviate\Users\Contracts\Services\Users\DeleteUserInterface;
use Deviate\Users\Exceptions\UserMustBeDisabledBeforeDeletingException;

class DeleteUser implements DeleteUserInterface
{
    private $fetchesUsers;
    private $deletesUsers;

    public function __construct(
        FetchUsersRepositoryInterface $fetchesUsers,
        DeleteUsersRepositoryInterface $deletesUsers
    ) {
        $this->fetchesUsers = $fetchesUsers;
        $this->deletesUsers = $deletesUsers;
    }

    public function deleteUser(string $userId): void
    {
        $user = $this->fetchesUsers->fetchUserById($userId);

        if ($user['disabled_at'] === null) {
            throw new UserMustBeDisabledBeforeDeletingException;
        }

        $this->deletesUsers->deleteUserById($userId);
    }
}
