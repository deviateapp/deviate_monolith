<?php

namespace Deviate\Activities\Contracts\Services\Invitations;

use Deviate\Shared\Search\SearchContainerInterface;

interface SearchInvitationsInterface
{
    public function listInvitedUsers(int $activityId, SearchContainerInterface $search): array;
    public function listInvitedActivities(int $userId, SearchContainerInterface $search): array;
}
