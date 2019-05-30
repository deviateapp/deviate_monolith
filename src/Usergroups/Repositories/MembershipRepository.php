<?php

namespace Deviate\Usergroups\Repositories;

use Deviate\Shared\Repositories\AbstractRepository;
use Deviate\Usergroups\Contracts\Repositories\MembershipRepositoryInterface;
use Illuminate\Database\ConnectionInterface;

class MembershipRepository extends AbstractRepository implements MembershipRepositoryInterface
{
    /** @var ConnectionInterface */
    private $database;

    public function __construct(ConnectionInterface $database)
    {
        $this->database = $database;
    }

    public function join(int $userId, int $usergroupId): bool
    {
        return (bool) $this->database->table('user_usergroup')
            ->insert([
                'user_id'      => $userId,
                'usergroup_id' => $usergroupId,
            ]);
    }

    public function remove(int $userId, int $usergroupId): bool
    {
        return (bool) $this->database->table('user_usergroup')
            ->where('user_id', $userId)
            ->where('usergroup_id', $usergroupId)
            ->delete();
    }

    public function removeByUsergroupId(int $usergroupId): bool
    {
        return (bool) $this->database->table('user_usergroup')
            ->where('usergroup_id', $usergroupId)
            ->delete();
    }

    public function removeByUserId(int $userId): bool
    {
        return (bool) $this->database->table('user_usergroup')
            ->where('user_id', $userId)
            ->delete();
    }

    public function listMembers(int $usergroupId): array
    {
        return $this->database->table('user_usergroup')
            ->where('usergroup_id', $usergroupId)
            ->pluck('user_id')
            ->toArray();
    }

    public function listUsergroupsMemberOf(int $userId): array
    {
        return $this->database->table('user_usergroup')
            ->where('user_id', $userId)
            ->pluck('usergroup_id')
            ->toArray();
    }
}
