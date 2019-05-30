<?php

namespace Deviate\Users\Services\Avatars;

use Deviate\Shared\Traits\ConvertsFileContent;
use Deviate\Users\Contracts\Repositories\CreateAvatarsRepositoryInterface;
use Deviate\Users\Contracts\Repositories\FetchUsersRepositoryInterface;
use Deviate\Users\Contracts\Services\Avatars\CreateAvatarInterface;
use Deviate\Users\Factories\Avatars\AvatarFactory;

class CreateAvatar implements CreateAvatarInterface
{
    use ConvertsFileContent;

    /** @var FetchUsersRepositoryInterface */
    private $fetchesUsers;

    /** @var CreateAvatarsRepositoryInterface */
    private $createsAvatars;

    /** @var AvatarFactory */
    private $factory;

    public function __construct(
        FetchUsersRepositoryInterface $fetchesUsers,
        CreateAvatarsRepositoryInterface $createsAvatars,
        AvatarFactory $factory
    ) {
        $this->fetchesUsers   = $fetchesUsers;
        $this->createsAvatars = $createsAvatars;
        $this->factory        = $factory;
    }

    public function createDefaultAvatar(int $userId): array
    {
        $this->fetchesUsers->fetchUserById($userId);

        $file = $this->fromFile($this->factory->make())->toUploadedFile();

        $path = $file->store($userId, 'avatars');

        $this->createsAvatars->recordNewAvatar($userId, $path);

        return [
            'user_id' => $userId,
            'path'    => $path,
        ];
    }
}
