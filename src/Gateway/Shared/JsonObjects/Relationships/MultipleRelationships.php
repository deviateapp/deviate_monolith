<?php

namespace Deviate\Gateway\Shared\JsonObjects\Relationships;

class MultipleRelationships extends AbstractRelationship
{
    protected function isSingular(): bool
    {
        return false;
    }
}
