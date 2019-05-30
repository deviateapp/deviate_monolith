<?php

namespace Deviate\Users\Contracts\Repositories;

interface DeleteAvatarsRepositoryInterface
{
    public function deleteAvatarByUserId(string $userId): bool;
    public function deleteAvatarsByOrganisationId(string $organisationId): bool;
}
