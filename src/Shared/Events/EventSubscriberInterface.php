<?php

namespace Deviate\Shared\Events;

use Illuminate\Contracts\Events\Dispatcher;

interface EventSubscriberInterface
{
    public function subscribe(Dispatcher $events): void;
}
