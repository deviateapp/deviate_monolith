<?php

namespace Deviate\Activities\Contracts\Services\Invitations;

interface UninviteUserInterface
{
    public function uninviteUserFromActivity(int $userId, int $activityId): void;
}
