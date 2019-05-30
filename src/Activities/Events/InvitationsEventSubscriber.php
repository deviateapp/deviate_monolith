<?php

namespace Deviate\Activities\Events;

use Deviate\Activities\Contracts\Events\InvitationsEventSubscriberInterface;
use Deviate\Activities\Contracts\Services\Invitations\InviteUserInterface;
use Deviate\Shared\Events\AbstractEventSubscriber;
use Deviate\Shared\Traits\ConvertsHashIds;

class InvitationsEventSubscriber extends AbstractEventSubscriber implements InvitationsEventSubscriberInterface
{
    use ConvertsHashIds;

    protected $events = [
        'activities.invite'                                  => 'handleInvite',
        'activities.uninvite'                                => 'handleUninvite',
        'activities.invitations.search.invited'              => 'handleListInvitedUsers',
        'activities.invitations.search.invitations_for_user' => 'handleListInvites',
    ];

    private $invitesUsers;

    public function __construct(InviteUserInterface $invitesUsers)
    {
        $this->invitesUsers = $invitesUsers;
    }

    public function handleInvite(array $payload): void
    {
        $this->invitesUsers->inviteUserToActivity($payload['user_id'], $payload['activity_id']);
    }

    public function handleUninvite(array $payload): void
    {
        // TODO: Implement handleUninvite() method.
    }

    public function handleListInvites(array $payload): array
    {
        // TODO: Implement handleListInvites() method.
    }

    public function handleListInvitedUsers(array $payload): array
    {
        // TODO: Implement handleListInvitedUsers() method.
    }
}
