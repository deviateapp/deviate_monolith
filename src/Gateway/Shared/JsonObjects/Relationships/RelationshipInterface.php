<?php

namespace Deviate\Gateway\Shared\JsonObjects\Relationships;

use Illuminate\Contracts\Support\Arrayable;

interface RelationshipInterface extends Arrayable
{
    public function type(): string;
}
