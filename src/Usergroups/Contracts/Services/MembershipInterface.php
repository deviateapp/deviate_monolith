<?php

namespace Deviate\Usergroups\Contracts\Services;

use Deviate\Shared\Search\SearchContainerInterface;

interface MembershipInterface
{
    public function join(string $userId, string $usergroupId): void;
    public function remove(string $userId, string $usergroupId): void;
    public function removeByUsergroupId(string $usergroupId): void;
    public function removeByUserId(string $userId): void;
    public function listMembers(string $usergroupId, SearchContainerInterface $search): array;
}
