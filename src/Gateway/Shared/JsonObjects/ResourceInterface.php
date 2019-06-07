<?php

namespace Deviate\Gateway\Shared\JsonObjects;

use Deviate\Gateway\Shared\JsonObjects\Relationships\RelationshipInterface;
use Illuminate\Contracts\Support\Arrayable;

interface ResourceInterface extends Arrayable
{
    public function addLink($type, $url = null): ResourceInterface;
    public function addMeta($key, $value = null): ResourceInterface;
    public function addRelationship(RelationshipInterface $relationship): ResourceInterface;
}
