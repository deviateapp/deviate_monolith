<?php

namespace Deviate\Users\Events\Subscribers;

use Deviate\Shared\Events\AbstractEventSubscriber;
use Deviate\Shared\Traits\ConvertsFileContent;
use Deviate\Users\Contracts\Events\AvatarsEventSubscriberInterface;
use Deviate\Users\Contracts\Services\Avatars\UpdateAvatarInterface;
use Deviate\Users\Contracts\Services\Avatars\CreateAvatarInterface;
use Deviate\Users\Contracts\Services\Avatars\FetchAvatarInterface;
use Deviate\Users\Contracts\Services\Avatars\DeleteAvatarInterface;

class AvatarsEventSubscriber extends AbstractEventSubscriber implements AvatarsEventSubscriberInterface
{
    use ConvertsFileContent;

    protected $events = [
        'users.avatars.upload'         => 'handleStoreAvatar',
        'users.avatars.create_default' => 'handleCreateDefaultAvatar',
        'users.avatars.fetch'          => 'handleFetchAvatar',
        'users.avatars.delete'         => 'handleDeleteAvatar',
    ];

    private $updateAvatar;
    private $createAvatar;
    private $fetchAvatar;
    private $deleteAvatar;

    public function __construct(
        UpdateAvatarInterface $updateAvatar,
        CreateAvatarInterface $createAvatar,
        FetchAvatarInterface $fetchAvatar,
        DeleteAvatarInterface $deleteAvatar
    ) {
        $this->updateAvatar = $updateAvatar;
        $this->createAvatar = $createAvatar;
        $this->fetchAvatar = $fetchAvatar;
        $this->deleteAvatar = $deleteAvatar;
    }

    public function handleStoreAvatar(array $payload): array
    {
        return $this->updateAvatar->uploadNewAvatar(
            $payload['id'],
            $this->fileFromContent($payload['content'])->toUploadedFile()
        );
    }

    public function handleCreateDefaultAvatar(array $payload): array
    {
        return $this->createAvatar->createDefaultAvatar($payload['id']);
    }

    public function handleDeleteAvatar(array $payload): void
    {
        $this->deleteAvatar->deleteByUserId($payload['id']);
    }

    public function handleFetchAvatar(array $payload): array
    {
        return $this->fetchAvatar->fetchAvatarByUserId($payload['id']);
    }
}
