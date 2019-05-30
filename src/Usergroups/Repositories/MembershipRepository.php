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

    public function join(string $userId, string $usergroupId): bool
    {
        return (bool) $this->database->table('user_usergroup')
            ->insert([
                'user_id'      => $this->decode($userId),
                'usergroup_id' => $this->decode($usergroupId),
            ]);
    }

    public function remove(string $userId, string $usergroupId): bool
    {
        return (bool) $this->database->table('user_usergroup')
            ->where('user_id', $this->decode($userId))
            ->where('usergroup_id', $this->decode($usergroupId))
            ->delete();
    }

    public function removeByUsergroupId(string $usergroupId): bool
    {
        return (bool) $this->database->table('user_usergroup')
            ->where('usergroup_id', $this->decode($usergroupId))
            ->delete();
    }

    public function removeByUserId(string $userId): bool
    {
        return (bool) $this->database->table('user_usergroup')
            ->where('user_id', $this->decode($userId))
            ->delete();
    }

    public function listMembers(string $usergroupId): array
    {
        return $this->database->table('user_usergroup')
            ->where('usergroup_id', $this->decode($usergroupId))
            ->pluck('user_id')
            ->map(function ($id) {
                return $this->encode($id);
            })
            ->toArray();
    }

    public function listUsergroupsMemberOf(string $userId): array
    {
        return $this->database->table('user_usergroup')
            ->where('user_id', $this->decode($userId))
            ->pluck('usergroup_id')
            ->map(function ($id) {
                return $this->encode($id);
            })
            ->toArray();
    }
}
