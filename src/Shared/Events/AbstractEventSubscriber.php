<?php

namespace Deviate\Shared\Events;

use Illuminate\Contracts\Events\Dispatcher;

abstract class AbstractEventSubscriber
{
    protected $events = [];

    public function subscribe(Dispatcher $events): void
    {
        foreach ($this->events as $event => $listener) {
            $events->listen($event, static::class . '@' . $listener);
        }
    }
}
