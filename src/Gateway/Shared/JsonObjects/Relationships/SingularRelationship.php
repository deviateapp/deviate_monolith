<?php

namespace Deviate\Gateway\Shared\JsonObjects\Relationships;

class SingularRelationship extends AbstractRelationship
{
    protected function isSingular(): bool
    {
        return true;
    }
}
