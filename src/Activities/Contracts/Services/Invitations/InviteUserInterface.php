<?php

namespace Deviate\Activities\Contracts\Services\Invitations;

interface InviteUserInterface
{
    public function inviteUserToActivity(string $userId, string $activityId): void;
}
