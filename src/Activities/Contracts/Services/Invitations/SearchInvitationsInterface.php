<?php

namespace Deviate\Activities\Contracts\Services\Invitations;

use Deviate\Shared\Search\SearchContainerInterface;

interface SearchInvitationsInterface
{
    public function listInvites(int $activityId, SearchContainerInterface $search): array;
}
