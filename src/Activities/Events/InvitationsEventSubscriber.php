<?php

namespace Deviate\Activities\Events;

use Deviate\Activities\Contracts\Events\InvitationsEventSubscriberInterface;
use Deviate\Activities\Contracts\Services\Invitations\InviteUserInterface;
use Deviate\Activities\Contracts\Services\Invitations\UninviteUserInterface;
use Deviate\Activities\Contracts\Services\Invitations\SearchInvitationsInterface;
use Deviate\Shared\Events\AbstractEventSubscriber;

class InvitationsEventSubscriber extends AbstractEventSubscriber implements InvitationsEventSubscriberInterface
{
    protected $events = [
        'activities.invite'                                  => 'handleInvite',
        'activities.uninvite'                                => 'handleUninvite',
        'activities.invitations.search.invited'              => 'handleListInvitedUsers',
        'activities.invitations.search.invitations_for_user' => 'handleListInvites',
    ];

    private $invitesUsers;
    private $uninvitesUsers;
    private $searchesInvitations;

    public function __construct(
        InviteUserInterface $invitesUsers,
        UninviteUserInterface $uninvitesUsers,
        SearchInvitationsInterface $searchesInvitations
    ) {
        $this->invitesUsers        = $invitesUsers;
        $this->uninvitesUsers      = $uninvitesUsers;
        $this->searchesInvitations = $searchesInvitations;
    }

    public function handleInvite(array $payload): void
    {
        $this->invitesUsers->inviteUserToActivity($payload['user_id'], $payload['activity_id']);
    }

    public function handleUninvite(array $payload): void
    {
        $this->uninvitesUsers->uninviteUserFromActivity($payload['user_id'], $payload['activity_id']);
    }

    public function handleListInvites(array $payload): array
    {

    }

    public function handleListInvitedUsers(array $payload): array
    {
        return $this->searchesInvitations->listInvites($payload['activity_id'], unserialize($payload['parameters']));
    }
}
