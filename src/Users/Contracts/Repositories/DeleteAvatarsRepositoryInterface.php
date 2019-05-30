<?php

namespace Deviate\Users\Contracts\Repositories;

interface DeleteAvatarsRepositoryInterface
{
    public function deleteAvatarByUserId(int $userId): bool;
    public function deleteAvatarsByOrganisationId(int $organisationId): bool;
}
