<?php

namespace Deviate\Usergroups\Events\Subscribers;

use Deviate\Shared\Events\AbstractEventSubscriber;
use Deviate\Usergroups\Contracts\Events\MembershipEventSubscriberInterface;
use Deviate\Usergroups\Contracts\Services\MembershipInterface;

class MembershipEventSubscriber extends AbstractEventSubscriber implements MembershipEventSubscriberInterface
{
    protected $events = [
        'usergroups.membership.join'                => 'handleJoin',
        'usergroups.membership.remove'              => 'handleRemove',
        'usergroups.membership.remove.user_id'      => 'handleRemoveByUserId',
        'usergroups.membership.remove.usergroup_id' => 'handleRemoveByUsergroupId',
        'usergroups.membership.search_members'      => 'handleListMembers',
    ];

    private $membership;

    public function __construct(MembershipInterface $membership)
    {
        $this->membership = $membership;
    }

    public function handleJoin(array $payload): void
    {
        $this->membership->join($payload['user_id'], $payload['usergroup_id']);
    }

    public function handleRemove(array $payload): void
    {
        $this->membership->remove($payload['user_id'], $payload['usergroup_id']);
    }

    public function handleRemoveByUserId(array $payload): void
    {
        $this->membership->removeByUserId($payload['id']);
    }

    public function handleRemoveByUsergroupId(array $payload): void
    {
        $this->membership->removeByUsergroupId($payload['id']);
    }

    public function handleListMembers(array $payload): array
    {
        return $this->membership->listMembers($payload['id'], unserialize($payload['parameters']));
    }
}
