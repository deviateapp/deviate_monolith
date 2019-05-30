<?php

namespace Deviate\Shared\Events;

use Illuminate\Contracts\Events\Dispatcher;

abstract class AbstractReactiveEvent
{
    /** @var array */
    private $data;

    public function __construct(array $payload)
    {
        $this->data = [$payload];
    }

    public function fire(): void
    {
        app(Dispatcher::class)->dispatch($this->getEventKey(), $this->data);
    }

    abstract protected function getEventKey(): string;
}
