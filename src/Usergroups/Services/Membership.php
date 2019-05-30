<?php

namespace Deviate\Usergroups\Services;

use Deviate\Shared\Search\Filters\MustBeIn;
use Deviate\Shared\Search\SearchContainerInterface;
use Deviate\Usergroups\Contracts\Repositories\FetchUsergroupsRepositoryInterface;
use Deviate\Usergroups\Contracts\Repositories\MembershipRepositoryInterface;
use Deviate\Usergroups\Contracts\Services\MembershipInterface;
use Deviate\Users\Client\FetchesUsersClientInterface;
use Deviate\Users\Client\SearchClientInterface;

class Membership implements MembershipInterface
{
    /** @var MembershipRepositoryInterface */
    private $repository;

    /** @var FetchUsergroupsRepositoryInterface */
    private $fetchesUsergroups;

    /** @var FetchesUsersClientInterface */
    private $fetchesUsers;

    /** @var SearchClientInterface */
    private $users;

    public function __construct(
        MembershipRepositoryInterface $repository,
        FetchUsergroupsRepositoryInterface $fetchesUsergroups,
        FetchesUsersClientInterface $fetchesUsers,
        SearchClientInterface $users
    ) {
        $this->repository        = $repository;
        $this->fetchesUsergroups = $fetchesUsergroups;
        $this->fetchesUsers      = $fetchesUsers;
        $this->users             = $users;
    }

    public function join(int $userId, int $usergroupId): void
    {
        $this->fetchesUsers->fetchUserById($userId)->rethrow();
        $this->fetchesUsergroups->fetchById($usergroupId);

        $this->repository->join($userId, $usergroupId);
    }

    public function remove(int $userId, int $usergroupId): void
    {
        $this->fetchesUsers->fetchUserById($userId)->rethrow();
        $this->fetchesUsergroups->fetchById($usergroupId);

        $this->repository->remove($userId, $usergroupId);
    }

    public function removeByUsergroupId(int $usergroupId): void
    {
        $this->fetchesUsergroups->fetchById($usergroupId);

        $this->repository->removeByUsergroupId($usergroupId);
    }

    public function removeByUserId(int $userId): void
    {
        $this->fetchesUsers->fetchUserById($userId)->rethrow();

        $this->repository->removeByUserId($userId);
    }

    public function listMembers(int $usergroupId, SearchContainerInterface $search): array
    {
        $this->fetchesUsergroups->fetchById($usergroupId);

        $members = $this->repository->listMembers($usergroupId);

        $search->addFilter(new MustBeIn('id', $members));

        return $this->users->search($search)->toArray();
    }
}
