<?php

namespace Deviate\Usergroups\Contracts\Repositories;

interface MembershipRepositoryInterface
{
    public function join(int $userId, int $usergroupId): bool;
    public function remove(int $userId, int $usergroupId): bool;
    public function removeByUsergroupId(int $usergroupId): bool;
    public function removeByUserId(int $userId): bool;
    public function listMembers(int $usergroupId): array;
    public function listUsergroupsMemberOf(int $userId): array;
}
