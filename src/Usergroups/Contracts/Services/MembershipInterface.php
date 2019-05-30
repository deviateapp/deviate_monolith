<?php

namespace Deviate\Usergroups\Contracts\Services;

use Deviate\Shared\Search\SearchContainerInterface;

interface MembershipInterface
{
    public function join(int $userId, int $usergroupId): void;
    public function remove(int $userId, int $usergroupId): void;
    public function removeByUsergroupId(int $usergroupId): void;
    public function removeByUserId(int $userId): void;
    public function listMembers(int $usergroupId, SearchContainerInterface $search): array;
}
