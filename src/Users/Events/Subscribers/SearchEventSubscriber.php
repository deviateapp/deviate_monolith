<?php

namespace Deviate\Users\Events\Subscribers;

use Deviate\Shared\Events\AbstractEventSubscriber;
use Deviate\Users\Contracts\Events\SearchEventSubscriberInterface;
use Deviate\Users\Contracts\Services\Users\FetchUserInterface;

class SearchEventSubscriber extends AbstractEventSubscriber implements SearchEventSubscriberInterface
{
    protected $events = [
        'users.search' => 'handleSearch',
    ];

    private $fetchUser;

    public function __construct(FetchUserInterface $fetchUser)
    {
        $this->fetchUser = $fetchUser;
    }

    public function handleSearch(array $payload): array
    {
        return $this->fetchUser->search(unserialize($payload['parameters']));
    }
}
