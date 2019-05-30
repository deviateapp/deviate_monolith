<?php

namespace Deviate\Users\Services\Avatars;

use Deviate\Users\Contracts\Repositories\CreateAvatarsRepositoryInterface;
use Deviate\Users\Contracts\Services\Avatars\UpdateAvatarInterface;
use Deviate\Users\Validators\UploadAvatarValidator;
use Illuminate\Http\UploadedFile;

class UpdateAvatar implements UpdateAvatarInterface
{
    /** @var CreateAvatarsRepositoryInterface */
    private $createsAvatars;

    /** @var UploadAvatarValidator */
    private $validator;

    public function __construct(
        CreateAvatarsRepositoryInterface $createsAvatars,
        UploadAvatarValidator $validator
    ) {
        $this->createsAvatars = $createsAvatars;
        $this->validator = $validator;
    }

    public function uploadNewAvatar(string $userId, UploadedFile $file): array
    {
        $this->validator->validate([
            'avatar' => $file,
        ]);

        $path = $file->store($userId, 'avatars');

        $this->createsAvatars->recordNewAvatar($userId, $path);

        return [
            'user_id' => $userId,
            'path'    => $path,
        ];
    }
}
