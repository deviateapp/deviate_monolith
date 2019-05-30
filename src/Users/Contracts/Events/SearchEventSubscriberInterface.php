<?php

namespace Deviate\Users\Contracts\Events;

use Deviate\Shared\Events\EventSubscriberInterface as BaseEventSubscriberInterface;

interface SearchEventSubscriberInterface extends BaseEventSubscriberInterface
{
    public function handleSearch(array $payload): array;
}
