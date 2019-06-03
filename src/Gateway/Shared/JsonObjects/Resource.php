<?php

namespace Deviate\Gateway\Shared\JsonObjects;

use Illuminate\Contracts\Support\Arrayable;

class Resource implements Arrayable
{
    private $schema;

    public function __construct($schema)
    {
        $this->schema = $schema;
    }

    public function toArray()
    {
        return [
            'type'          => $this->schema->getType(),
            'id'            => $this->schema->getId(),
            'attributes'    => $this->schema->toArray(),
            'links'         => [],
            'relationships' => [],
            'meta'          => [],
        ];
    }
}
