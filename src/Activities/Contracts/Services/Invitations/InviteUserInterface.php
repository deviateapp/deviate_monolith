<?php

namespace Deviate\Activities\Contracts\Services\Invitations;

interface InviteUserInterface
{
    public function inviteUserToActivity(int $userId, int $activityId): void;
}
