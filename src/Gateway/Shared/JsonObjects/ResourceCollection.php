<?php

namespace Deviate\Gateway\Shared\JsonObjects;

use Closure;
use Deviate\Gateway\Shared\JsonObjects\Relationships\RelationshipInterface;
use Illuminate\Support\Collection;

class ResourceCollection extends Collection
{
    public function addRelationships(RelationshipInterface $relationship, ?Closure $filter = null): void
    {
        $callback = $filter ? $filter : function () {
            return true;
        };

        $this->filter($callback)->each(function (Resource $resource) use ($relationship) {
            $resource->addRelationship($relationship);
        });
    }
}
