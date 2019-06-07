<?php

namespace Deviate\Gateway\Shared\JsonObjects\Relationships;

use Illuminate\Support\Collection;

class RelationshipCollection extends Collection
{
    public function toArray()
    {
        return $this->filter(function ($item) {
            return $item instanceof RelationshipInterface;
        })->mapWithKeys(function (RelationshipInterface $relationship) {
            return [$relationship->type() => $relationship->toArray()];
        }, $this->items)->items;
    }
}
