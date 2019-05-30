<?php

namespace Deviate\Usergroups\Contracts\Repositories;

interface MembershipRepositoryInterface
{
    public function join(string $userId, string $usergroupId): bool;
    public function remove(string $userId, string $usergroupId): bool;
    public function removeByUsergroupId(string $usergroupId): bool;
    public function removeByUserId(string $userId): bool;
    public function listMembers(string $usergroupId): array;
    public function listUsergroupsMemberOf(string $userId): array;
}
